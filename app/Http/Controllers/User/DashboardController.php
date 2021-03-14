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
        $users= DB::table('users');
        $usercount=$users->count();
        $hotels=DB::table('hotels');
        $hotelcount=$hotels->count();
        $tours=DB::table('tours')->where('status','=','Active');
        $tourcount=$tours->count();
        $bookingtour=DB::table('book_tour');
        $bookingcount=$bookingtour->count();


        return view('user.dashboard.index',compact('user','profile','usercount','hotelcount','tourcount','bookingcount'));
    }

    public function destroy($slug)
    {
        return $slug;
    }


}
