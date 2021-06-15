<?php

namespace App\Http\Controllers\Vehicle;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
class VehicleSearchController extends Controller
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
            'make' => 'nullable|string|regex:/^[a-zA-Z ]*$/',
            'min_price' => 'required|integer|gte:0',
            'max_price' => 'required|integer|gt:0|max:120000',
        ]);

        $cities = City::all();

        $vehicles = Vehicle::whereBetween('price', [$request->min_price, $request->max_price]);

        if($request->filled('name'))
        {
            $vehicles->where('name' , 'LIKE' , "%{$request->name}%" );
        }
        if($request->filled('city'))
        {
            $vehicles->where('city'  , "{$request->city}" );
        }
        if($request->filled('make'))
        {
            $vehicles->where('make','>=',"{$request->make}");
        }


        $request->flash();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $vehicles = $vehicles()->paginate(15);

            return view('admin.dashboard.vehicle.index',compact('vehicles','cities'));
        }elseif ($request->routeIs('dashboard*'))
        {
            $vehicles->where('user_id','=',auth()->user()->id);
            $vehicles = $vehicles->paginate(15);

            return view('user.dashboard.vehicle.index',compact('vehicles','cities'));
        }

        //Check if status is Active
        $vehicles->where('status','=',Status::Active);

        $vehicles = $vehicles->paginate(15);

        return view('vehicle.index',compact('vehicles','cities'));
    }
}
