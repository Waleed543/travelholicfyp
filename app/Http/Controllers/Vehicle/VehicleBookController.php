<?php

namespace App\Http\Controllers\vehicle;

use App\City;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\vehicle\book_vehicle;
use App\Model\book_vehicle as book;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class VehicleBookController extends Controller
{
    public function index($slug)
    {
        $cities = City::all();
        $vehicle = Vehicle::where('slug','=',$slug)->first();
        abort_if($vehicle == null,'404','Vehicle not found');

        $dt = \Illuminate\Support\Carbon::now();
        $date_today = $dt->toDateString();
        $date_max = ($dt->addDays(10))->toDateString();;

        return view('vehicle.book',compact('vehicle','cities','date_today','date_max'));
    }

    public function book(book_vehicle $request, $slug)
    {
        $vehicle = $request->vehicle;

        $number = book::select('number')->orderBy('created_at','desc')->limit(1)->first();

        if($number == null)
        {
            $number = 200001;
        }else{
            $number = $number->number+1;
        }

        //Combine departure date and time
        $date = strval($request->input('departure_date'));;
        $time = strval($request->input('departure_time'));;
        $departure = date('Y-m-d H:i:s', strtotime("$date $time"));
        //Combine returning date and time
        $date = strval($request->input('returning_date'));;
        $time = strval($request->input('returning_time'));;
        $returning = date('Y-m-d H:i:s', strtotime("$date $time"));

        $book_vehicle = book::create([
            'user_id' => $request->user()->id,
            'vehicle_id' => $vehicle->id,
            'number' => $number,
            'days' => $request->total_days,
            'adults' => $request->adults,
            'children' => $request->children,
            'phone' => $request->phone,
            'departure_city' => $request->departure_city,
            'destination_city' => $request->destination_city,
            'departure_date' => $departure,
            'returning_date' => $returning,
            'status' => BookingStatus::Reserved,
            'payment_status' => PaymentStatus::Unpaid,
            'payment_type' => $request->payment_type,
        ]);


        return redirect(route('dashboard.vehicle.book.payment',$book_vehicle->number));
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

        $vehicle = $book->vehicle;

        $book->total_cost = $vehicle->price * $book->days;
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
