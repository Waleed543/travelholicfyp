<?php

namespace App\Http\Controllers\Vehicle;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\vehicle\EditRequest;
use App\Model\tags_vehicle;
use App\Tag;
use App\Vehicle;
use App\Http\Requests\vehicle\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
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
        $vehicles = Vehicle::with('user')
            ->where('status','=',Status::Active)
            ->orderBy('id','desc')->paginate(6);
        $cities = City::all();
        return view('vehicle.index',compact('vehicles','cities'));
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
        $vehicle = new Vehicle;

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

            $path = $request->file('image')->storeAs(auth()->user()->username.'/vehicle/', $fileNameToStore,'public');

            $vehicle->thumbnail = $fileNameToStore;

        }


        //store in db

        $vehicle->user_id = auth()->user()->id;
        $vehicle->name = $request->input('name');
        //Slug Create
        $slug = Str::slug( $request->name, "-");
        $slug = $slug."-";
        $temp = Vehicle::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
        if($temp != null)
        {
            $count = Str::afterLast($temp->slug, '-');
            $count +=1;
        }else{
            $count = 1;
        }
        $slug = $slug."".$count;

        $vehicle->slug = strtolower($slug);

        $vehicle->model =  $request->input('model');
        $vehicle->make =  $request->input('make');
        $vehicle->color = $request->input('color');
        $vehicle->condition = $request->input('condition');
        $vehicle->year = $request->input('year');
        $vehicle->mileage = $request->input('mileage');
        $vehicle->vinumber = $request->input('vinumber');
        $vehicle->price = $request->input('price');
        $vehicle->city = $request->input('city');
        $vehicle->description = $request->input('description');
        $vehicle->status = Status::InProgress;

        $vehicle->save();

        //create tags
        if($request->tags != null)
        {
            foreach ($request->tags as $name)
            {
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);

                $tags_tour = tags_vehicle::create([
                    'vehicle_id' => $vehicle->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        return back()->with('popup_success', 'Vehicle Successfully Created');

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
    public function update(EditRequest $request, $vehicle)
    {
        $vehicle = Vehicle::where('slug' , $vehicle)->first();

        abort_if($vehicle == null,'404');
        abort_unless($vehicle->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

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

            $path = $request->file('image')->storeAs(auth()->user()->username.'/vehicle/', $fileNameToStore,'public');

            Storage::delete('public/'.$vehicle->user->username.'/vehicle/'.$vehicle->thumbnail);
            $vehicle->thumbnail = $fileNameToStore;

        }


        //store in db

        $vehicle->name = $request->input('name');
        //Slug Create
        if($vehicle->name != $request->name)
        {
            $slug = Str::slug( $request->name, "-");
            $slug = $slug."-";
            $temp = Vehicle::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
            if($temp != null)
            {
                $count = Str::afterLast($temp->slug, '-');
                $count +=1;
            }else{
                $count = 1;
            }
            $slug = $slug."".$count;

            $vehicle->slug = strtolower($slug);
        }

        $vehicle->model =  $request->input('model');
        $vehicle->make =  $request->input('make');
        $vehicle->color = $request->input('color');
        $vehicle->condition = $request->input('condition');
        $vehicle->year = $request->input('year');
        $vehicle->mileage = $request->input('mileage');
        $vehicle->vinumber = $request->input('vinumber');
        $vehicle->price = $request->input('price');
        $vehicle->city = $request->input('city');
        $vehicle->description = $request->input('description');
        $vehicle->status = Status::InProgress;

        $vehicle->save();

        //delete changed tags
        $p_tags = $vehicle->tags;
        foreach ($p_tags as $p_tag)
        {
            if($request->tags == null or !in_array($p_tag->name,$request->tags))
            {
                $vehicle->tags()->detach($p_tag);
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

                $tags_tour = tags_vehicle::firstOrCreate([
                    'vehicle_id' => $vehicle->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        return back()->with('popup_success', 'Vehicle Successfully Updated');
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
}
