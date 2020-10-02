<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreRequest;
use App\Model\tags_tour;
use App\Tag;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();
        $cities= city::all();
        return view('admin.dashboard.hotel.index',compact('hotels','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.dashboard.hotel.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $hotel = new Hotel;

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

            $path = $request->file('image')->storeAs(auth()->user()->username.'/hotel/', $fileNameToStore,'public');

            $hotel->thumbnail = $fileNameToStore;

        }



        //store in db

        $hotel->user_id = auth()->user()->id;
        $hotel->name = $request->input('name');
        //Slug Create
        $slug = Str::slug( $request->name, "-");
        $slug = $slug."-";
        $temp = Hotel::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
        if($temp != null)
        {
            $count = Str::afterLast($temp->slug, '-');
            $count +=1;
        }else{
            $count = 1;
        }
        $slug = $slug."".$count;


        $hotel->slug = strtolower($slug);




        $hotel->total_rooms = $request->input('total_rooms');
        $hotel->available_rooms= $request->input('total_rooms');
        $hotel->description = $request->input('description');
        $hotel->price = $request->input('price');

        $hotel->status = Status::InProgress;


        $hotel->save();

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
                    'hotel_id' => $hotel->id,
                    'tag_id' => $hotel->id
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $hotel = Hotel::where('slug' , $slug)->first();

        abort_if($hotel == null,'404','Hotel not found');


        $cities = City::all();

        return view('admin.dashboard.hotel.edit',compact('hotel','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        dd("Travelholic");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function setting()
    {

    }
}
