<?php

namespace App\Http\Controllers\Tour;

use App\Enums\Payment;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\book_tour;
use App\Model\book_tour as book;
use App\Tour;
use Illuminate\Http\Request;

class TourBookController extends Controller
{

    public function index($slug)
    {
        $tour = Tour::where('slug','=',$slug)->first();
        abort_if($tour == null,'404','Tour not found');

        return view('tour.book',compact('tour'));
    }

    public function book(book_tour $request, $slug)
    {
        $tour = $request->tour;

        $tour->remaining_seats -= $request->seats;

        $tour->save();

        $book_tour = book::create([
            'user_id' => $request->user()->id,
            'tour_id' => $tour->id,
            'seats' => $request->seats,
            'adults' => $request->adults,
            'children' => $request->children,
            'phone' => $request->phone,
            'status' => Status::InProgress,
            'payment_status' => 0,
            'payment_type' => Payment::Cash,

        ]);




        return back()->with('popup_success','Tour has been booked');
    }
}
