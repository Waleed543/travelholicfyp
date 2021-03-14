<?php

namespace App\Http\Controllers\Booking;

use App\City;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Model\book_hotel;
use App\Model\book_tour;
use App\model\book_vehicle;
use App\Tour;
use App\Vehicle;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function tour(Request $request)
    {
        $this->validate($request, [
            'tour_slug' => 'nullable',
            'order_no' => 'nullable',
            'phone_no' => 'nullable',
        ]);

        $book_tours = book_tour::query();
        $tours = Tour::select('slug','name')->where('status',Status::Active)->get();

        if($request->filled('tour_slug'))
        {
            $tour = Tour::where('slug', "{$request->tour_slug}" )->first();
            if ($tour != NULL)
            {
                $book_tours = $book_tours->where('tour_id', $tour->id);
            }
        }
        if($request->filled('order_no'))
        {
            $book_tours->where('number','=',"{$request->order_no}" );
        }
        if($request->filled('phone_no'))
        {
            $book_tours->where('phone','=',"{$request->phone_no}" );
        }

        $request->flash();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $book_tours = $book_tours->paginate(15);

            return view('admin.dashboard.booking.tour',compact('book_tours','tours'));
        }

        $book_tours->where('user_id','=',auth()->user()->id);
        $book_tours = $book_tours->paginate(15);

        return view('dashboard.booking.tour',compact('book_tours','tours'));

    }

    public function hotel(Request $request)
    {
        $this->validate($request, [
            'hotel_slug' => 'nullable',
            'order_no' => 'nullable',
            'phone_no' => 'nullable',
        ]);

        $book_hotels = book_hotel::query();
        $hotels = Hotel::select('slug','name')->where('status',Status::Active)->get();

        if($request->filled('hotel_slug'))
        {
            $hotel = Hotel::where('slug', "{$request->hotel_slug}" )->first();
            if ($hotel != NULL)
            {
                $book_hotels = $book_hotels->where('hotel_id', $hotel->id);
            }
        }
        if($request->filled('order_no'))
        {
            $book_hotels->where('number','=',"{$request->order_no}" );
        }
        if($request->filled('phone_no'))
        {
            $book_hotels->where('phone','=',"{$request->phone_no}" );
        }

        $request->flash();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $book_hotels = $book_hotels->paginate(15);

            return view('admin.dashboard.booking.hotel',compact('book_hotels','hotels'));
        }

        $book_hotels->where('user_id','=',auth()->user()->id);
        $book_hotels = $book_hotels->paginate(15);

        return view('dashboard.booking.hotel',compact('book_hotels','hotels'));

    }

    public function vehicle(Request $request)
    {
        $this->validate($request, [
            'vehicle_slug' => 'nullable',
            'order_no' => 'nullable',
            'phone_no' => 'nullable',
        ]);

        $book_vehicles = book_vehicle::query();
        $vehicles = Vehicle::select('slug','name')->where('status',Status::Active)->get();
        $cities = City::all();

        if($request->filled('vehicle_slug'))
        {
            $vehicle = Vehicle::where('slug', "{$request->vehicle_slug}" )->first();
            if ($vehicle != NULL)
            {
                $book_hotels = $book_vehicles->where('vehicle_id', $vehicle->id);
            }
        }
        if($request->filled('order_no'))
        {
            $book_vehicles->where('number','=',"{$request->order_no}" );
        }
        if($request->filled('phone_no'))
        {
            $book_vehicles->where('phone','=',"{$request->phone_no}" );
        }

        $request->flash();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $book_vehicles = $book_vehicles->paginate(15);

            return view('admin.dashboard.booking.vehicle',compact('book_vehicles','vehicles','cities'));
        }

        $book_vehicles->where('user_id','=',auth()->user()->id);
        $book_vehicles = $book_vehicles->paginate(15);

        return view('dashboard.booking.vehicle',compact('book_vehicles','vehicles','cities'));

    }
}
