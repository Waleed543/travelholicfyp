<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleBookingController extends Controller
{
    public function vehicle()
    {
        $book_tours = book_tour::paginate(15);

        $tours = Tour::select('slug','name')->where('status',Status::Active)->get();

        return view('admin.dashboard.booking.tour',compact('book_tours','tours'));
    }
}
