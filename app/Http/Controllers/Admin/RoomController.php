<?php

namespace App\Http\Controllers\Admin;

use App\Facility;
use App\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function create($slug)
    {
        $hotel = Hotel::where('slug',$slug)->first();

        abort_if($hotel == null,'404');
        $facilities = Facility::all();

        return view('admin.dashboard.hotel.room.create',compact('facilities','slug'));
    }

}
