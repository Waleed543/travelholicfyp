<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\model\book_vehicle;
use App\Tour;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleBookingController extends Controller
{
    public function vehicle()
    {
        $book_vehicles = book_vehicle::paginate(15);

        $vehicles = Vehicle::select('slug','name')->where('status',Status::Active)->get();

        $cities = City::all();

        return view('admin.dashboard.booking.vehicle',compact('book_vehicles','cities','vehicles'));
    }

    public function status(Request $request, $number)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        $book_vehicle = book_vehicle::where('number' , $number)->first();

        if ($validator->fails() or $book_vehicle == null)
        {
            return response()->json([
                'message'   => 'Status was unable to change',
                'error' => 1
            ]);
        }

        switch ($request->status)
        {
            case BookingStatus::Reserved:
                $book_vehicle->status = BookingStatus::Reserved;
                break;
            case BookingStatus::Booked:
                $book_vehicle->status = BookingStatus::Booked;
                break;
            default:
                return response()->json([
                    'message'   => 'Status was unable to change',
                    'error' => 1
                ]);

        }

        $book_vehicle->save();

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

        $book_vehicle = book_vehicle::where('number' , $number)->first();

        if ($validator->fails() or $book_vehicle == null)
        {
            return response()->json([
                'message'   => 'Payment status was unable to change',
                'error' => 1
            ]);
        }

        switch ($request->payment_status)
        {
            case PaymentStatus::Unpaid:
                if($book_vehicle->payment_status == PaymentStatus::Unpaid)
                {
                    break;
                }
                $book_vehicle->payment_status = PaymentStatus::Unpaid;
                break;
            case PaymentStatus::UnderReview:
                if($book_vehicle->payment_status == PaymentStatus::UnderReview)
                {
                    break;
                }
                $book_vehicle->payment_status = PaymentStatus::UnderReview;
                break;
            case PaymentStatus::Successful:
                if($book_vehicle->payment_status == PaymentStatus::Successful)
                {
                    break;
                }
                $book_vehicle->status = BookingStatus::Booked;
                $book_vehicle->payment_status = PaymentStatus::Successful;
                break;
            default:
                return response()->json([
                    'message'   => 'Status was unable to change',
                    'error' => 1
                ]);
        }

        $book_vehicle->save();

        return response()->json([
            'message'   => 'Booking Payment Status changed',
            'error' => 0
        ]);
    }


public function cancel($number)
    {
        $book_vehicle = book_vehicle::where('number' , $number)->first();

        $book_vehicle->status = BookingStatus::Canceled;
        $book_vehicle->save();

        return back()->with('popop_success', 'Order has been canceled');
    }
}
