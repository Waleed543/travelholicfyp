<?php

namespace App\Http\Controllers\User;

use App\City;
use App\Http\Controllers\Controller;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\Status;

class TourController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $tours = auth()->user()->tours()->paginate(15);
        return view('user.dashboard.tour.index',compact('tours','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('user.dashboard.tour.create',compact('cities'));
    }
    public function edit($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Tour not found');
        abort_if($tour->user_id != auth()->user()->id,'401');

        $cities = City::all();

        return view('user.dashboard.tour.edit',compact('tour','cities'));
    }

    public function destroy($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Blog not found');
        abort_if($tour->user_id != auth()->user()->id,'401');

        //Deleting Tour Thumbnail
        Storage::delete('public/'.auth()->user()->username.'/tour/'.$tour->thumbnail);

        //deleting tags;
        $tour->tags()->detach();

        //Deleting Tour
        $tour->delete();

        return back()->with('popup_success','Tour deleted successfully');
    }

    public function status($slug)
        {
                $tour = Tour::where('slug' , $slug)->first();

                abort_if($tour == null,'404','Tour not found');
                abort_if($tour->user_id != auth()->user()->id,'401');

                $tour->status= Status::InActive;

                $tour->save();

                return back()->with('popup_success','Success');

        }
        public function statusRequested($slug)
        {
                $tour = Tour::where('slug' , $slug)->first();

                abort_if($tour == null,'404','Tour not found');
                abort_if($tour->user_id != auth()->user()->id,'401');

                $tour->status= Status::Requested;

                $tour->save();

                return back()->with('popup_success','Success');

        }

    public function profile($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Tour not found');
        abort_if($tour->user_id != auth()->user()->id,'401');

        $departure_date = new \Illuminate\Support\Carbon( $tour->departure_date);
        $returning_date = new \Illuminate\Support\Carbon( $tour->returning_date);
        $difference = ($departure_date->diff($returning_date)->days);

        $tour->days = $difference;

        $tour_days = $tour->tour_days;

        return view('user.dashboard.tour.profile',compact('tour','tour_days'));
    }
}
