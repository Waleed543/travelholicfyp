<?php

namespace App\Http\Controllers\User;

use App\Facility;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    public function index($slug)
    {
        $hotel = Hotel::where('slug',$slug)
            ->where('user_id',auth()->user()->id)->first();
        abort_if($hotel == null,'404');

        $rooms = $hotel->rooms;

        return view('user.dashboard.hotel.room.index',compact('slug','rooms'));
    }
    public function create($slug)
    {
        $hotel = Hotel::where('slug',$slug)
            ->where('user_id',auth()->user()->id)->first();

        abort_if($hotel == null,'404');
        $facilities = Facility::all();

        return view('user.dashboard.hotel.room.create',compact('facilities','slug'));
    }

    public function edit($slug, $room_slug)
    {
        $hotel = Hotel::where('slug',$slug)
            ->where('user_id',auth()->user()->id)->first();
        abort_if($hotel == null,'404');
        $room = Room::where('slug',$room_slug)->first();

        abort_if($room == null,'404');

        $facilities = Facility::all();
        $room_facilities = $room->facilities;

        return view('user.dashboard.hotel.room.edit',compact('facilities','slug','room_slug','room','room_facilities'));
    }
}
