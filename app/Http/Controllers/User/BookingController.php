<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\book_tour;
use App\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function tour()
    {
        $bookings = auth()->user()->book_tour()->with('tour')->paginate(15);

        return view('user.dashboard.booking.tour',compact('bookings'));
    }
    public function hotel()
    {
        $bookings = auth()->user()->book_hotel()->with('hotel','room')->paginate(15);

        return view('user.dashboard.booking.hotel',compact('bookings'));
    }

    public function payment($order_table, $number, Request $request)
    {
        $number = Payment::withTrashed()->select('number')->orderBy('created_at','desc')->limit(1)->first();
        if($number == null)
        {
            $number = 100001;
        }else{
            $number = $number->number+1;
        }

        $reservation = Payment::create([
            'user_id' => $request->user()->id,
            'order_table' => $order_table,
            'number' => $number
        ]);
    }

}
