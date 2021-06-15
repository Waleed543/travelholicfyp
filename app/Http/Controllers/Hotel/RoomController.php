<?php

namespace App\Http\Controllers\Hotel;

use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\hotel\Room\EditRequest;
use App\Http\Requests\hotel\Room\StoreRequest;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($slug, StoreRequest $request)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');

        //check if room type already exists
        $temp = Room::where('name',$request->name)
            ->where('hotel_id',$hotel->id)->first();

        if($temp != null)
        {
            return back()->with('popup_error','Room Type already exists');
        }

        $room = new Room;

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

            $path = $request->file('image')->storeAs(auth()->user()->username.'/hotel/room/', $fileNameToStore,'public');

            $room->thumbnail = $fileNameToStore;

        }

        //Slug Create
        $slug = Str::slug( $request->name, "-");
        $slug = $slug."-";
        $temp = Room::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
        if($temp != null)
        {
            $count = Str::afterLast($temp->slug, '-');
            $count +=1;
        }else{
            $count = 1;
        }
        $slug = $slug."".$count;


        $room->slug = strtolower($slug);

        $room->hotel_id = $hotel->id;
        $room->name = $request->name;
        $room->total = $request->total;

        $room->beds = $request->beds;
        $room->capacity = $request->capacity;
        $room->beds = $request->beds;
        $room->available = $request->total;
        $room->description = $request->description;
        $room->price = $request->price;
        $room->status = Status::InProgress;

        $room->save();

        $room->facilities()->attach($request->facility);

        $hotel->total_rooms = $hotel->total_rooms+$room->total;
        $hotel->available_rooms = $hotel->available_rooms+$room->total;

        $hotel->save();

        return back()->with('popup_success','Room created successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $room_slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');

        $room = Room::where('slug',$room_slug)
            ->where('hotel_id',$hotel->id)->first();
        abort_if($room == null,'404');

        $facilities = $room->facilities;

        return view('hotel.rooms.show',compact('hotel','room','facilities'));
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
    public function update(EditRequest $request, $slug, $room_slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');

        $room = Room::where('slug',$room_slug)
            ->where('hotel_id',$hotel->id)->first();
        abort_if($room == null,'404');

        abort_unless($hotel->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        if($room->total-$room->available > $request->total)
        {
            return back()->with('popup_error','Rooms has been booked, You cannot reduce the total rooms');
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

            Storage::delete('public/'.$hotel->user->username.'/hotel/room/'.$room->thumbnail);
            $path = $request->file('image')->storeAs($hotel->user->username.'/hotel/room/', $fileNameToStore,'public');

            $room->thumbnail = $fileNameToStore;

        }

        //Slug Create
        $slug = Str::slug( $request->name, "-");
        $room->slug = strtolower($slug);

        $room->name = $request->name;
        $room->total = $request->total;
        $room->beds = $request->beds;
        $room->capacity = $request->capacity;
        $room->available = $request->total;
        $room->description = $request->description;
        $room->price = $request->price;

        $room->save();

        $room->facilities()->sync($request->facility);

        //hotel rooms update
        $rooms = $hotel->rooms;
        $sum = 0;
        $available = 0;
        if($rooms != null)
        {
            foreach ($rooms as $room)
            {
                $total = $sum + $room->total;
                $available = $available + $room->available;
            }
        }
        $hotel->total_rooms = $total;
        $hotel->available_rooms = $available;
        $hotel->save();

        return back()->with('popup_success','Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $room_slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();
        abort_if($hotel == null,'404');
        $room = Room::where('slug',$room_slug)
            ->where('hotel_id',$hotel->id)->first();
        abort_if($room == null,'404');

        abort_unless($hotel->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        if($room->total - $room->available !=0)
        {
            return back()->with('popup_error','Rooms has been booked, You cannot delete this room type because rooms are booked');
        }
        //Deleting Room Thumbnail
        Storage::delete('public/'.$hotel->user->username.'/hotel/room/'.$room->thumbnail);

        //deleting tags;
        $room->facilities()->detach();

        //deleting hotel rooms
        $hotel->total_rooms = $hotel->total_rooms - $room->total;
        $hotel->available_rooms = $hotel->available_rooms-$room->total;

        $hotel->save();

        //Deleting Room
        $room->delete();

        return back()->with('popup_success','Room Type deleted successfully');
    }
}
