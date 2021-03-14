<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Model\book_tour;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function tour()
    {
        $book_tours = book_tour::paginate(15);

        $tours = Tour::select('slug','name')->where('status',Status::Active)->get();

        return view('admin.dashboard.booking.tour',compact('book_tours','tours'));
    }


    public function cancel($number)
    {
        $book_tour = book_tour::where('number',$number)->first();
        abort_if($book_tour == null,'404','Reservation not found');
        $tour = $book_tour->tour;

        abort_unless($tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $book_tour->status = BookingStatus::Canceled;
        $book_tour->save();

        return back()->with('popop_success', 'Order has been Canceled');
    }

    public function status(Request $request, $number)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        $book_tour = book_tour::where('number' , $number)->first();

        if ($validator->fails() or $book_tour == null)
        {
            return response()->json([
                'message'   => 'Status was unable to change',
                'error' => 1
            ]);
        }

        switch ($request->status)
        {
            case BookingStatus::Reserved:
                if($book_tour->status == BookingStatus::Booked)
                {
                    if($book_tour->status == BookingStatus::Reserved)
                    {
                        break;
                    }
                    $tour = $book_tour->tour;
                    $tour->remaining_seats += $book_tour->seats;
                    $tour->save();
                }
                $book_tour->status = BookingStatus::Reserved;
                break;
            case BookingStatus::Booked:
                if($book_tour->status == BookingStatus::Booked)
                {
                    break;
                }
                $tour = $book_tour->tour;
                $tour->remaining_seats -= $book_tour->seats;
                $tour->save();
                $book_tour->status = BookingStatus::Booked;
                break;
        }

        $book_tour->save();

        return response()->json([
            'message'   => 'Booking Status changed',
            'error' => 0
        ]);
    }

    public function paymentStatus(Request $request, $number)
    {
        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|string'
        ]);

        $book_tour = book_tour::where('number' , $number)->first();

        if ($validator->fails() or $book_tour == null)
        {
            return response()->json([
                'message'   => 'Payment status was unable to change',
                'error' => 1
            ]);
        }

        switch ($request->payment_status)
        {
            case PaymentStatus::Unpaid:
                if($book_tour->payment_status == PaymentStatus::Unpaid)
                {
                    break;
                }
                if($book_tour->status == BookingStatus::Booked)
                {
                    $tour = $book_tour->tour;
                    $tour->remaining_seats += $book_tour->seats;
                    $tour->save();
                    $book_tour->status = BookingStatus::Reserved;
                }
                $book_tour->payment_status = PaymentStatus::Unpaid;
                break;
            case PaymentStatus::UnderReview:
                if($book_tour->payment_status == PaymentStatus::UnderReview)
                {
                    break;
                }
                if($book_tour->status == BookingStatus::Booked)
                {
                    $tour = $book_tour->tour;
                    $tour->remaining_seats += $book_tour->seats;
                    $tour->save();
                    $book_tour->status = BookingStatus::Reserved;
                }
                $book_tour->payment_status = PaymentStatus::UnderReview;
                break;
            case PaymentStatus::Successful:
                if($book_tour->payment_status == PaymentStatus::Successful)
                {
                    break;
                }
                if($book_tour->status != BookingStatus::Booked)
                {
                    $tour = $book_tour->tour;
                    $tour->remaining_seats -= $book_tour->seats;
                    $tour->save();
                }
                $book_tour->status = BookingStatus::Booked;
                $book_tour->payment_status = PaymentStatus::Successful;
                break;
        }

        $book_tour->save();

        return response()->json([
            'message'   => 'Booking Payment Status changed',
            'error' => 0
        ]);
    }
}
