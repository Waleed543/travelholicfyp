<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\book_tour;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function tour()
    {
        $bookings = auth()->user()->book_tour;
        return view('user.dashboard.booking.tour',compact('bookings'));
    }
}
