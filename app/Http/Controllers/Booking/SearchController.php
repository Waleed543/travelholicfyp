<?php

namespace App\Http\Controllers\Booking;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Model\book_tour;
use App\Tour;
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
}
