<?php

namespace App\Http\Controllers\Hotel;

use App\City;
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

        $hotels = Hotel::where('');
    }
}
