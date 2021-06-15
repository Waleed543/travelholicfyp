<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $profile = DB::table('user_profile')->where('user_id','=',$user->id)->first();

        $hotelcount = $user->hotels()->count();

        $tourcount = $user->tours()->count();

        $vehiclecount = $user->vehicles()->count();


        return view('user.dashboard.index',compact('user','profile','hotelcount','tourcount','vehiclecount'));
    }

    public function destroy($slug)
    {
        return $slug;
    }


}
