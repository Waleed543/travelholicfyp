<?php

namespace App\Http\Controllers\user;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $vehicles = auth()->user()->vehicles()->paginate(15);
        return view('user.dashboard.vehicle.index',compact('vehicles','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('user.dashboard.vehicle.create',compact('cities'));
    }

    public function edit($slug)
    {
        $vehicle = Vehicle::where('slug' , $slug)->first();
        abort_if($vehicle == null,'404','Vehicle not found');
        abort_if($vehicle->user_id != auth()->user()->id,'401');


        $cities = City::all();

        return view('user.dashboard.vehicle.edit',compact('vehicle','cities'));
    }

    public function status($slug)
    {
        $vehicle = Vehicle::where('slug' , $slug)->first();

        abort_if($vehicle == null,'404','Vehicle not found');
        abort_if($vehicle->user_id != auth()->user()->id,'401');

        $vehicle->status= Status::InActive;

        $vehicle->save();

        return back()->with('popup_success','Success');

    }
    public function statusRequested($slug)
        {
                $vehicle = Vehicle::where('slug' , $slug)->first();

                abort_if($vehicle == null,'404','Vehicle not found');
                abort_if($vehicle->user_id != auth()->user()->id,'401');

                $vehicle->status= Status::Requested;

                $vehicle->save();

                return back()->with('popup_success','Success');

        }
}
