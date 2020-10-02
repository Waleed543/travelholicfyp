<?php

namespace App\Http\Controllers\Hotel;

use App\City;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\EditRequest;
use App\Http\Requests\Hotel\StoreRequest;
use App\Model\tags_hotel;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
        return view('hotel.index');
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
        $hotel->city= $request->input('city');


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

                $tags_tour = tags_hotel::create([
                    'hotel_id' => $hotel->id,
                    'tag_id' => $hotel->id
                ]);
            }
        }


        return back()->with('popup_success', 'Hotel Successfully Created');
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
    public function update(EditRequest $request, $slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();

        abort_if($hotel == null,'404');
        abort_unless($hotel->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');



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

            Storage::delete('public/'.$hotel->user->username.'/hotel/'.$hotel->thumbnail);
            $path = $request->file('image')->storeAs($hotel->user->username.'/hotel/', $fileNameToStore,'public');

            $hotel->thumbnail = $fileNameToStore;

        }



        //update in db

        $hotel->name = $request->input('name');
        //Slug Create
        if($hotel->name != $request->name)
        {
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
        }


        $hotel->slug = strtolower($slug);




        $hotel->total_rooms = $request->input('total_rooms');
        $hotel->available_rooms= $request->input('total_rooms');
        $hotel->description = $request->input('description');
        $hotel->price = $request->input('price');
        $hotel->city= $request->input('city');


        $hotel->status = Status::InProgress;


        $hotel->save();

        //delete changed tags
        $p_tags = $hotel->tags;
        if($p_tags != null)
        foreach ($p_tags as $p_tag)
        {
            if($request->tags == null or !in_array($p_tag->name,$request->tags))
            {
                $hotel->tags()->detach($p_tag);
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

                $tags_hotel = tags_tour::firstOrCreate([
                    'hotel_id' => $hotel->id,
                    'tag_id' => $tag->id
                ]);
            }
        }


        return back()->with('popup_success', 'Hotel Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();
        abort_if($hotel == null,'404');
        abort_unless($hotel->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');
        //Deleting Tour Thumbnail
        Storage::delete('public/'.$hotel->user->username.'/hotel/'.$hotel->thumbnail);

        //delete rooms

        //deleting tags;
        $hotel->tags()->detach();

        //Deleting Tour
        $hotel->delete();

        return back()->with('popup_success','Hotel deleted successfully');

    }
}
