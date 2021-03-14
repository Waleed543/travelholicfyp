<?php

namespace App\Http\Controllers\Tour;

use App\Enums\BookingStatus;
use App\Enums\Payment;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RecommendorController;
use App\Http\Requests\Tour\book_tour;
use App\Model\book_tour as book;
use App\Reservation;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
            'payment_status' => PaymentStatus::Unpaid,
            'payment_type' => $request->payment_type,
        ]);
        RecommendorController::TourRecommendor();


        return redirect(route('dashboard.tour.book.payment',$book_tour->number));
    }

    public function cancel($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $tour = $book->tour;
        abort_unless($book->user_id == auth()->user()->id or $tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $book->status = Status::Canceled;
        $book->save();

        return back()->with('popop_success', 'Order has been Canceled');

    }

    public function booked($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $tour = $book->tour;

        abort_unless($tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');


        $book->status = BookingStatus::Booked;
        $book->save();

        return back()->with('popop_success', 'Order has been booked');
    }

    public function destroy($number)
    {
        $book_tour = book::where('number',$number)->first();
        abort_if($book_tour == null,'404','Reservation not found');
        abort_unless($book_tour->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        if($book_tour->status == BookingStatus::Booked or $book_tour->payment_status == PaymentStatus::Successful or $book_tour->payment_status == PaymentStatus::UnderReview)
        {
            return back()->with('popup_error', 'Order cannot be deleted because its payment has been received or under review. Kindly contact support');
        }

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
        $book_tour->payment_status = PaymentStatus::UnderReview;
        $book_tour->save();


        return redirect(route('dashboard.tour.booking'))->with('popup_success','Your payment details will be updated in few hours');

    }
}
