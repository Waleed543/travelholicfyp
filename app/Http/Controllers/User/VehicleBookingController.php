<?php

namespace App\Http\Controllers\user;

use App\City;
use App\Enums\BookingStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\model\book_vehicle;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehicleBookingController extends Controller
{
    public function index()
    {
        $user_vehicles = auth()->user()->vehicles()->with('bookings');
        $user_vehicles = $user_vehicles->paginate(15);

        $cities = City::all();
        $vehicles = Vehicle::select('slug','name')->where('status',Status::Active)->get();

        return view('user.dashboard.vehicle.booking',compact('user_vehicles','vehicles','cities'));
    }

}
