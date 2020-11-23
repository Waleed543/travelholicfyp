<?php

namespace App\Http\Controllers\Hotel;

use App\Enums\BookingStatus;
use App\Enums\Payment;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Hotel;
use App\Model\book_hotel;
use App\Http\Controllers\Controller;
use App\Model\book_hotel as book;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelBookController extends Controller
{
    public function index($slug,$room_slug)
    {
        $hotel = Hotel::where('slug','=',$slug)->first();
        abort_if($hotel == null,'404','Hotel not found');
        $room = Room::where('slug','=',$room_slug)
                    ->where('hotel_id',$hotel->id)->first();
        abort_if($room == null,'404','Room not found');
        return view('hotel.book',compact('hotel','room'));
    }

    public function book(\App\Http\Requests\Hotel\book_hotel $request, $slug, $room_slug)
    {
        $hotel = $request->hotel;

        $room = Room::where('slug','=',$room_slug)
            ->where('hotel_id',$hotel->id)->first();

        abort_if($room == null,'404','Room not found');

        if($room->available < $request->total_rooms)
        {
            return back()->with('popup_error','There are not enough rooms');
        }

        if($room->capacity < $request->adults+$request->children)
        {
            return back()->with('popup_error','Only '.$room->capacity.' persons allowed');
        }

        $number = book::select('number')->orderBy('created_at','desc')->limit(1)->first();

        if($number == null)
        {
            $number = 200001;
        }else{
            $number = $number->number+1;
        }

        $book_hotel = book_hotel::create([
            'user_id' => $request->user()->id,
            'hotel_id' => $hotel->id,
            'room_id' => $room->id,
            'number' => $number,
            'total_rooms' => $request->total_rooms,
            'adults' => $request->adults,
            'children' => $request->children,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => BookingStatus::Reserved,
            'payment_status' => 0,
            'payment_status' => PaymentStatus::Unpaid,
            'payment_type' => $request->payment_type,
        ]);

        $room->available -= $request->total_rooms;
        $hotel->available_rooms -= $request->total_rooms;

        $hotel->save();
        $room->save();

        return redirect(route('dashboard.hotel.book.payment',$book_hotel->number));
    }

    public function destroy($number)
    {
        $book_hotel = book::where('number',$number)->first();
        abort_if($book_hotel == null,'404','Reservation not found');

        if($book_hotel->status == BookingStatus::Booked or $book_hotel->payment_status == PaymentStatus::Successful or $book_hotel->payment_status == PaymentStatus::UnderReview)
        {
            return back()->with('popup_error', 'Order cannot be deleted because its payment has been received or under review. Kindly contact support');
        }

        $book_hotel->delete();

        return back()->with('popop_success', 'Order has been deleted');

    }

    public function payment($number)
    {
        $book = \App\Model\book_hotel::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $room = Room::where('id','=',$book->room_id)->first();
        abort_if($room == null,'404','Room not found');

        $book->total_cost = $room->price * $book->total_rooms;
        return view('user.dashboard.hotel.easypaisa',compact('book'));
    }

    public function storePayment($number, Request $request)
    {
        $book = \App\Model\book_hotel::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $validator = Validator::make($request->all(), [
            'trxinput' => 'required|int',
        ]);
        $book->trxid = $request->trxinput;
        $book->payment_status = PaymentStatus::UnderReview;
        $book->save();


        return redirect(route('dashboard.hotel.booking'))->with('popup_success','Your payment details will be updated in few hours');

    }

}
