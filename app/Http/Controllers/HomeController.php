<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Enums\Status;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\EditRequest;
use App\Http\Requests\Hotel\StoreRequest;
use App\Model\tags_hotel;
use App\Tag;
use App\Tour;
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
        $tours = Tour::with('user')->where('status','=',Status::Active)
            ->orderBy('created_at','desc');
        $tours_count = count($tours->get());
        $tours = $tours->limit(6)->get();

        $blogs = Blog::with('user')->where('status','=',Status::Active)
            ->orderBy('created_at','desc');

        $blogs_count = count($blogs->get());
        $blogs = $blogs->limit(6)->get();

        $users_count = count(User::all());

        return view('home',compact('tours','blogs','tours_count','blogs_count','users_count'));
    }
    public function  contactus()
    {
        return view('contactus');
    }

    public function showProfile($username)
    {
        $user = User::find($username);

        $profile = DB::table('user_profile')->where('user_id','=',$user->id)->first();
        $city = DB::table('city')->where('id','=',$profile->city_id)->first();
        return view('viewProfile',compact('user','profile','city'));
    }
}
