<?php

namespace App\Http\Controllers\Tour;

use App\Enums\BookingStatus;
use App\Enums\Payment;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\book_tour;
use App\Model\book_tour as book;
use App\Reservation;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $number = book::select('number')->orderBy('created_at','desc')->limit(1)->first();

        if($number == null)
        {
            $number = 200001;
        }else{
            $number = $number->number+1;
        }

        $book_tour = book::create([
            'user_id' => $request->user()->id,
            'tour_id' => $tour->id,
            'number' => $number,
            'seats' => $request->seats,
            'adults' => $request->adults,
            'children' => $request->children,
            'phone' => $request->phone,
            'status' => BookingStatus::Reserved,
            'payment_status' => 0,
            'payment_type' => $request->payment_type,
        ]);


        return redirect(route('dashboard.tour.book.payment',$book_tour->number));
    }

    public function destroy($number)
    {
        $book_tour = book::where('number',$number)->first();
        abort_if($book_tour == null,'404','Reservation not found');

        if($book_tour->status == BookingStatus::UnderReview or $book_tour->status == BookingStatus::Booked)
        {
            return back()->with('popop_error', 'Order cannot be deleted because its payment has been received or under review. Kindly contact support');
        }
        $tour = $book_tour->tour;

        $tour->remaining_seats += $book_tour->seats;
        $tour->save();

        $book_tour->delete();

        return back()->with('popop_success', 'Order has been deleted');

    }

    public function payment($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $tour = $book->tour;

        $book->total_cost = $tour->price * $book->seats;
        return view('user.dashboard.tour.easypaisa',compact('book'));
    }

    public function storePayment($number, Request $request)
    {
        $book_tour = book::where('number',$number)->first();
        abort_if($book_tour == null,'404','Reservation not found');

        $validator = Validator::make($request->all(), [
            'trxinput' => 'required|int',
        ]);

        $book_tour->trxid = $request->trxinput;
        $book_tour->status = BookingStatus::UnderReview;
        $book_tour->save();


        return redirect(route('dashboard.tour.booking'))->with('popup_success','Your payment details will be updated in few hours');

    }
}
