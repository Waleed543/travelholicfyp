<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Facility;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index($slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');

        $rooms = $hotel->rooms;

        return view('admin.dashboard.hotel.room.index',compact('slug','rooms','hotel'));
    }
    public function create($slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');
        $facilities = Facility::all();

        return view('admin.dashboard.hotel.room.create',compact('facilities','slug'));
    }

    public function edit($slug, $room_slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();
        abort_if($hotel == null,'404');

        $room = Room::where('slug',$room_slug)->first();
        abort_if($room == null,'404');

        $facilities = Facility::all();
        $room_facilities = $room->facilities;

        return view('admin.dashboard.hotel.room.edit',compact('facilities','slug','room_slug','room','room_facilities'));
    }

    public function status(Request $request, $hotel_slug, $room_slug)
    {
        $room = Room::where('slug',$room_slug)->first();


        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);


        $room = Room::where('slug' , $room_slug)->first();

        if ($validator->fails() or $room == null)
        {
            return response()->json([
                'message'   => 'Status was unable to change',
                'error' => 1
            ]);
        }

        switch ($request->status)
        {
            case Status::InProgress:
                $room->status = Status::InProgress;
                break;
            case Status::InActive:
                $room->status = Status::InActive;
                break;
            case Status::Active:
                $room->status = Status::Active;
                break;
        }


        $room->save();

        return response()->json([
            'message'   => 'Status changed',
            'error' => 0
        ]);
    }


}
