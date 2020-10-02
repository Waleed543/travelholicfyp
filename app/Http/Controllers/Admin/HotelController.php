<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\hotel\StoreRequest;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        $cities= city::all();
        return view('admin.dashboard.hotel.index',compact('hotels','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.dashboard.hotel.create',compact('cities'));
    }

    public function edit($slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();

        abort_if($hotel == null,'404','Hotel not found');


        $cities = City::all();
        dd($hotel->city);

        return view('admin.dashboard.hotel.edit',compact('hotel','cities'));
    }
}
