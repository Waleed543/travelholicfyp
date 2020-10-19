<?php

namespace App\Http\Controllers\Hotel;

use App\Enums\Payment;
use App\Enums\Status;
use App\Hotel;
use App\Model\book_hotel;
use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Http\Request;

class HotelBookController extends Controller
{
    public function index($slug,$room_slug)
    {
        $hotel = Hotel::where('slug','=',$slug)->first();
        abort_if($hotel == null,'404','Hotel not found');
        $room = Room::where('slug','=',$room_slug)
                    ->where('hotel_id',$hotel->id)->first();
        abort_if($room == null,'404','Room not found');
        return view('user.dashboard.hotel.book',compact('hotel','room'));
    }

    public function book(book_hotel $request, $slug, $room_slug)
    {
        $hotel = $request->hotel;

        $hotel->available -= $request->total_rooms;

        $room = Room::where('slug','=',$room_slug)
            ->where('hotel_id',$hotel->id)->first();

        abort_if($room == null,'404','Room not found');

        $room->available -= $request->total_rooms;

        if($room->available < $request->total_rooms)
        {
            return back()->with('popup_error','There are not enough rooms');
        }

        $book_hotel = book_hotel::create([
            'total_rooms' => $request->total_rooms,
            'adults' => $request->adults,
            'children' => $request->children,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => Status::InProgress,
            'payment_status' => 0,
            'payment_type' => Payment::Cash,
        ]);


        $hotel->save();
        $room->save();

        return back()->with('popup_success','Room has been booked');
    }
}
