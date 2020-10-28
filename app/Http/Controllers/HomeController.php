<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\EditRequest;
use App\Http\Requests\Hotel\StoreRequest;
use App\Model\tags_hotel;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showProfile($username)
    {
        $user = User::find($username);

        $profile = DB::table('user_profile')->where('user_id','=',$user->id)->first();
        $city = DB::table('city')->where('id','=',$profile->city_id)->first();
        return view('viewProfile',compact('user','profile','city'));
    }
}
