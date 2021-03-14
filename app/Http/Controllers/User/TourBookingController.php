<?php

namespace App\Http\Controllers\User;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Tour;
use App\Vehicle;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{
    public function index()
    {
        $user_tours = auth()->user()->tours()->with('bookings');
        $user_tours = $user_tours->paginate(15);

        $cities = City::all();
        $tours = Tour::select('slug','name')->where('status',Status::Active)->get();

        return view('user.dashboard.tour.booking',compact('user_tours','tours','cities'));
    }
}
