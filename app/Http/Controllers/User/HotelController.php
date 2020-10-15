<?php

namespace App\Http\Controllers\User;

use App\City;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\User;
use App\Enums\Status;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = auth()->user()->hotels;
        $cities= city::all();
        return view('user.dashboard.hotel.index',compact('hotels','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('user.dashboard.hotel.create',compact('cities'));
    }

    public function edit($slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();

        abort_if($hotel == null,'404','Hotel not found');
        abort_if($hotel->user_id != auth()->user()->id,'401');


        $cities = City::all();


        return view('user.dashboard.hotel.edit',compact('hotel','cities'));
    }
    public function status($slug)
    {
            $hotel = Hotel::where('slug' , $slug)->first();

            abort_if($hotel == null,'404','Hotel not found');
            abort_if($hotel->user_id != auth()->user()->id,'401');

            $hotel->status= Status::InActive;

            $hotel->save();

            return back()->with('popup_success','Success');

    }


}
