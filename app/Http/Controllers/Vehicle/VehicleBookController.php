<?php

namespace App\Http\Controllers\vehicle;

use App\City;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\vehicle\book_vehicle;
use App\Model\book_vehicle as book;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class VehicleBookController extends Controller
{
    public function index($slug)
    {
        $cities = City::all();
        $vehicle = Vehicle::where('slug','=',$slug)->first();
        abort_if($vehicle == null,'404','Vehicle not found');

        $bookings = $vehicle->bookings()->orderBy('departure_date','asc')->where('status','=','Booked')->get();

        $booking_dates = array();
        foreach ($bookings as $book)
        {
            $period = CarbonPeriod::create($book->departure_date, $book->returning_date);

            // Convert the period to an array of dates
            $dates = $period->toArray();
            // Iterate over the period
            foreach ($dates as $date) {
                $date = $date->format('d-m-Y');
                array_push($booking_dates,$date);
            }

        }



        $dt = \Illuminate\Support\Carbon::now();
        $date_today = $dt->toDateString();
       // $date_max = ($dt->addDays(10))->toDateString();

        return view('vehicle.book',compact('vehicle','cities','date_today','booking_dates'));
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

    public function cancel($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $vehicle = $book->vehicle;
        abort_unless($book->user_id == auth()->user()->id or $vehicle->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $book->status = Status::Canceled;
        $book->save();

        return back()->with('popop_success', 'Order has been Canceled');

    }

    public function booked($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $vehicle = $book->vehicle;

        abort_unless($vehicle->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');


        $book->status = BookingStatus::Booked;
        $book->save();

        return back()->with('popop_success', 'Order has been booked');
    }

    public function destroy($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');
        abort_unless($book->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        $book->delete();

        return back()->with('popop_success', 'Order has been deleted');

    }

    public function payment($number)
    {
        $book = book::where('number',$number)->first();
        abort_if($book == null,'404','Reservation not found');

        $vehicle = $book->vehicle;

        $book->total_cost = $vehicle->price * $book->days;
        return view('user.dashboard.vehicle.easypaisa',compact('book'));
    }

    public function storePayment($number, Request $request)
    {
        $book_vehicle = book::where('number',$number)->first();
        abort_if($book_vehicle == null,'404','Reservation not found');

        $validator = Validator::make($request->all(), [
            'trxinput' => 'required|int',
        ]);

        $book_vehicle->trxid = $request->trxinput;
        $book_vehicle->payment_status = PaymentStatus::UnderReview;
        $book_vehicle->save();


        return redirect(route('dashboard.vehicle.booking'))->with('popup_success','Your payment details will be updated in few hours');

    }
}
