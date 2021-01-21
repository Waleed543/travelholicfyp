<?php

namespace App\Http\Controllers\Hotel;

use App\City;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelSearchController extends Controller
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
            'city' => 'nullable|integer|exists:city,id',
            'rooms' => 'nullable|integer|gte:0',
        ]);

        $cities = City::all();

<<<<<<< HEAD
        $hotels = Hotel::query();

        if($request->filled('name'))
        {
            $hotels->where('name' , 'LIKE' , "%{$request->name}%" );
        }
        if($request->filled('city'))
        {
            $hotels->where('city'  , "{$request->city}" );
        }
        if($request->filled('rooms'))
        {
            $hotels->where('available_rooms','>=',"{$request->rooms}");
        }

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $hotels = $hotels->paginate(15);

            return view('admin.dashboard.hotel.index',compact('hotels','cities'));
        }
        elseif ($request->routeIs('dashboard*'))
        {
            $hotels->where('user_id','=',auth()->user()->id);
            $hotels = $hotels->paginate(15);

            return view('user.dashboard.hotel.index',compact('hotels','cities'));
        }

        //Check if status is Active
        $hotels->where('status','=',Status::Active);

        $hotels = $hotels->paginate(6);

        $request->flash();
        return view('hotel.index',compact('hotels','cities'));
=======
        $hotels = Hotel::where('')
>>>>>>> parent of 8cadabb... recommender changes
    }
}
