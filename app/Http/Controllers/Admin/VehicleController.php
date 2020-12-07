<?php

namespace App\Http\Controllers\admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $vehicles = Vehicle::paginate(15);
        return view('admin.dashboard.vehicle.index',compact('vehicles','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.dashboard.vehicle.create',compact('cities'));
    }

    public function edit($slug)
    {
        $vehicle = Vehicle::where('slug' , $slug)->first();
        abort_if($vehicle == null,'404','Vehicle not found');

        $cities = City::all();

        return view('admin.dashboard.vehicle.edit',compact('vehicle','cities'));
    }
}
