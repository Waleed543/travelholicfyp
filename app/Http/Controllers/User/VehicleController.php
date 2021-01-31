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

    public function status(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        $vehicle = Vehicle::where('slug' , $slug)->first();

        if ($validator->fails() or $vehicle == null)
        {
            return response()->json([
                'message'   => 'Status was unable to change:200',
                'error' => 1
            ]);
        }
        switch ($request->status)
        {
            case Status::InProgress:
                $vehicle->status = Status::InProgress;
                break;
            case Status::InActive:
                $vehicle->status = Status::InActive;
                break;
            case Status::Active:
                $vehicle->status = Status::Active;
                break;
        }

        $vehicle->save();

        return response()->json([
            'message'   => 'Status changed',
            'error' => 0
        ]);
    }
}
