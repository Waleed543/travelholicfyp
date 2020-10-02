<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Tour;
use Illuminate\Http\Request;
use App\Http\Requests\hotel\StoreRequest;
use Illuminate\Support\Facades\Storage;

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


        return view('admin.dashboard.hotel.edit',compact('hotel','cities'));
    }
    public function  delete($slug)
    {




    }
}
