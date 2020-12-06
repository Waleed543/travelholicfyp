<?php

namespace App\Http\Controllers\Vehicle;

use App\City;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     * use to allow only guest
     */
    public function __construct()
    {
        $this->middleware('auth' , ['except' => ['index','show','search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::with('user')
            ->where('status','=',Status::Active)
            ->orderBy('id','desc')->paginate(6);
        $cities = City::all();
        return view('vehicle.index',compact('vehicles','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('vehicle');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
