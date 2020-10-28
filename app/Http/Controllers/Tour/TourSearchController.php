<?php

namespace App\Http\Controllers\tour;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tour;
class TourSearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|string|regex:/^[a-zA-Z ]*$/',
            'departure_city' => 'nullable|integer|exists:city,id',
            'destination_city' => 'nullable|integer|exists:city,id',
            'seats' => 'nullable|integer|gte:0',
            'min_price' => 'required|integer|gte:0',
            'max_price' => 'required|integer|gt:0|max:120000',
        ]);

        $cities = City::all();

        $tours = Tour::whereBetween('price', [$request->min_price, $request->max_price]);

        if($request->filled('name'))
        {
            $tours->where('name' , 'LIKE' , "%{$request->name}%" );
        }
        if($request->filled('departure_city'))
        {
            $tours->where('departure_city'  , "{$request->departure_city}" );
        }
        if($request->filled('destination_city'))
        {
            $tours->where('destination_city'  , "{$request->destination_city}" );
        }
        if($request->filled('seats'))
        {
            $tours->where('remaining_seats','>=',"{$request->seats}");
        }


        $request->flash();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $tours = $tours()->paginate(15);

            return view('admin.dashboard.tour.index',compact('tours','cities'));
        }elseif ($request->routeIs('dashboard*'))
        {
            $tours->where('user_id','=',auth()->user()->id);
            $tours = $tours->paginate(15);

            return view('user.dashboard.tour.index',compact('tours','cities'));
        }

        //Check if status is Active
        $tours->where('status','=',Status::Active);

        $tours = $tours()->paginate(15);

        return view('tour.index',compact('tours','cities'));
    }
}
