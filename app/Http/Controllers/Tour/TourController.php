<?php

namespace App\Http\Controllers\Tour;

use App\City;
use App\Enums\PaymentStatus;
use App\Http\Controllers\RecommendorController;
use App\Model\tags_tour;
use App\Model\tour_day;
use App\Tag;
use App\Tour;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\StoreRequest;
use App\Http\Requests\Tour\EditRequest;
use App\Http\Requests\Tour\ProfileRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\Status;

class TourController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * use to allow only guest
     */
    public function __construct()
    {
        $this->middleware('auth' , ['except' => ['index','show','search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours = Tour::with('user')
            ->where('status','=',Status::Active)
            ->orderBy('id','desc')->paginate(6);
        $cities = City::all();
        $recommendationg = new RecommendorController();
        if(auth()->user()!=null) {

            $recommendations=$recommendationg->GetRecommendationTour(auth()->user()->id);
            return view('tour.index',compact('tours','cities','recommendations'));
        }
        else
        {
            return view('tour.index',compact('tours','cities'));
        }





    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $tour = new Tour;

        //validate file upload
        if ($request->hasFile('image')) {
            //get file name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('image')->storeAs(auth()->user()->username.'/tour/', $fileNameToStore,'public');

            $tour->thumbnail = $fileNameToStore;

        }


        //store in db

        $tour->user_id = auth()->user()->id;
        $tour->name = $request->input('name');
        //Slug Create
        $slug = Str::slug( $request->name, "-");
        $slug = $slug."-";
        $temp = Tour::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
        if($temp != null)
        {
            $count = Str::afterLast($temp->slug, '-');
            $count +=1;
        }else{
            $count = 1;
        }
        $slug = $slug."".$count;

        $tour->slug = strtolower($slug);

        $tour->departure_city =  $request->input('departure_city');
        $tour->destination_city = $request->input('destination_city');

        $date = strval($request->input('departure_date'));;
        $time = strval($request->input('departure_time'));;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $tour->departure_date = $combinedDT;

        $date = strval($request->input('returning_date'));;
        $time = strval($request->input('returning_time'));;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $tour->returning_date = $combinedDT;

        $tour->nights_to_stay = $request->input('nights_to_stay');
        $tour->total_seats = $request->input('total_seats');
        $tour->remaining_seats = $request->input('total_seats');
        $tour->description = $request->input('description');
        $tour->price = $request->input('price');

        $tour->status = Status::InProgress;

        $tour->save();

        //create tags
        if($request->tags != null)
        {
            foreach ($request->tags as $name)
            {
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);

                $tags_tour = tags_tour::create([
                    'tour_id' => $tour->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        return back()->with('popup_success', 'Tour Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $tour = Tour::with('user')->where('slug','=',$slug)
            ->where('status','=',Status::Active)
            ->first();

        abort_if($tour == null,'404');

        $tour_days = $tour->tour_days;
        return view('tour.show',compact('tour','tour_days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $tour)
    {
        $slug = $tour;
        $tour = Tour::where('slug' , $slug)->first();

        abort_if($tour == null,'404');
        abort_unless($tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $booked_seats = $tour->total_seats-$tour->remaining_seats;
        if ($booked_seats > $request->total_seats)
        {
            return back()->with('popup_error', 'Seats has been booked, you cannot reduce the total seats. Kindly contact support');
        }else{
            $tour->remaining_seats = $request->total_seats - $booked_seats;
        }

        //validate file upload
        if ($request->hasFile('image')) {
            //get file name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('image')->storeAs(auth()->user()->username.'/tour/', $fileNameToStore,'public');

            Storage::delete('public/'.$tour->user->username.'/tour/'.$tour->thumbnail);
            $tour->thumbnail = $fileNameToStore;

        }


        //store in db

        $tour->name = $request->input('name');
        //Slug Create
        if($tour->name != $request->name)
        {
            $slug = Str::slug( $request->name, "-");
            $slug = $slug."-";
            $temp = Tour::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
            if($temp != null)
            {
                $count = Str::afterLast($temp->slug, '-');
                $count +=1;
            }else{
                $count = 1;
            }
            $slug = $slug."".$count;

            $tour->slug = strtolower($slug);
        }


        $tour->departure_city =  $request->input('departure_city');
        $tour->destination_city = $request->input('destination_city');

        $date = strval($request->input('departure_date'));;
        $time = strval($request->input('departure_time'));;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $tour->departure_date = $combinedDT;

        $date = strval($request->input('returning_date'));;
        $time = strval($request->input('returning_time'));;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $tour->returning_date = $combinedDT;

        $tour->nights_to_stay = $request->input('nights_to_stay');
        $tour->total_seats = $request->input('total_seats');
        $tour->description = $request->input('description');
        $tour->price = $request->input('price');

        $tour->status = Status::InProgress;
        $tour->save();

        //delete changed tags
        $p_tags = $tour->tags;
        foreach ($p_tags as $p_tag)
        {
            if($request->tags == null or !in_array($p_tag->name,$request->tags))
            {
                $tour->tags()->detach($p_tag);
            }
        }
        //create new tags
        if($request->tags != null)
        {
            foreach ($request->tags as $name)
            {
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);

                $tags_tour = tags_tour::firstOrCreate([
                    'tour_id' => $tour->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        return back()->with('popup_success', 'Tour Successfully Updated');
    }

    public function profile(ProfileRequest $request, $slug)
    {
        $tour = $request->tour;
        $tour_days = $tour->tour_days;



        if ($tour_days->count() != 0)
        {
            foreach ($tour_days as $day)
            {
                $day->description = $request->input("day-".$day->number);
                $day->save();
            }
        }else{
            for ($i = 1;$i<=$request->days;$i++)
            {
                $day = new tour_day;
                $day->tour_id = $tour->id;
                $day->number = $i;
                $day->description = $request->input("day-".$i);
                $day->save();
            }
        }

        return back()->with('popup_success','Tour Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $tour = Tour::where('slug', $slug)->first();
        abort_if($tour == null, '404', 'Tour not found');
        abort_unless($tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $bookings = $tour->bookings;
        $bookings_count = $bookings->where('payment_status',PaymentStatus::Successful)->count() > 0;
        $booked_seats = $tour->total_seats - $tour->remaining_seats;
        if ($booked_seats != 0) {
            return back()->with('popup_error', 'Seats has been booked, you cannot delete the tour. Kindly contact support');
        }elseif($bookings_count > 0)
        {
            return back()->with('popup_error', 'Payment has been made against your tour, you cannot delete the tour. Kindly contact support');
        }

        //Deleting Tour Thumbnail
        Storage::delete('public/' . $tour->user->username . '/tour/' . $tour->thumbnail);

        //deleting tags
        $tour->tags()->detach();
        //deleting tour days
        $tour_days = $tour->tour_days;
        foreach ($tour_days as $day) {
            $day->delete();
        }

        //Deleting Tour Bookings
        foreach ($bookings as $book)
        {
            $book->delete();
        }
        //Deleting Tour
        $tour->delete();

        return back()->with('popup_success', 'Tour deleted successfully');
    }
}
