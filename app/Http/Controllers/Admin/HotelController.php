<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\hotel\StoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\Status;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::paginate(15);
        $cities= city::all();
        return view('admin.dashboard.hotel.index',compact('hotels','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.dashboard.hotel.create',compact('cities'));
    }

    public function edit($slug)
    {
        $hotel = Hotel::where('slug' , $slug)->first();

        abort_if($hotel == null,'404','Hotel not found');


        $cities = City::all();


        return view('admin.dashboard.hotel.edit',compact('hotel','cities'));
    }

    public function status(Request $request, $slug)
        {

            $validator = Validator::make($request->all(), [
                'status' => 'required|string'
            ]);


            $hotel = Hotel::where('slug' , $slug)->first();

            if ($validator->fails() or $hotel == null)
            {
                return response()->json([
                    'message'   => 'Status was unable to change',
                    'error' => 1
                ]);
            }

            switch ($request->status)
            {
                case Status::InProgress:
                    $hotel->status = Status::InProgress;
                    break;
                case Status::InActive:
                    $hotel->status = Status::InActive;
                    break;
                case Status::Active:
                    $hotel->status = Status::Active;
                    break;
            }


            $hotel->save();

            return response()->json([
                'message'   => 'Status changed',
                'error' => 0
            ]);
        }
}
