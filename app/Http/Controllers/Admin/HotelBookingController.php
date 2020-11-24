<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\book_hotel;
use Illuminate\Http\Request;

class HotelBookingController extends Controller
{
    public function tour()
    {
        $book_hotels = book_hotel::paginate(15);

        $hotels = Hotel::select('slug','name')->where('status',Status::Active)->get();

        return view('admin.dashboard.booking.tour',compact('book_hotels','hotels'));
    }
}
