<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Enums\Status;

class TourController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $tours = Tour::all();
        return view('admin.dashboard.tour.index',compact('tours','cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.dashboard.tour.create',compact('cities'));
    }
    public function edit($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Tour not found');


        $cities = City::all();

        return view('admin.dashboard.tour.edit',compact('tour','cities'));
    }

    public function status(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        $tour = Tour::where('slug' , $slug)->first();

        if ($validator->fails() or $tour == null)
        {
            return response()->json([
                'message'   => 'Status was unable to change',
                'error' => 1
            ]);
        }
        switch ($request->status)
        {
            case Status::InProgress:
                $tour->status = Status::InProgress;
                break;
            case Status::InActive:
                $tour->status = Status::InActive;
                break;
            case Status::Active:
                $tour->status = Status::Active;
                break;
        }

        $tour->save();

        return response()->json([
            'message'   => 'Status changed',
            'error' => 0
        ]);
    }

    public function destroy($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Tour not found');


        //Deleting Tour Thumbnail
        Storage::delete('public/'.$tour->user->username.'/tour/'.$tour->thumbnail);

        //deleting tags
        $tour->tags()->detach();
        //deleting tour days
        $tour_days = $tour->tour_days;
        foreach($tour_days as $day)
        {
            $day->delete();
        }

        //Deleting Tour
        $tour->delete();

        return back()->with('popup_success','Tour deleted successfully');
    }

    public function profile($slug)
    {
        $tour = Tour::where('slug' , $slug)->first();
        abort_if($tour == null,'404','Tour not found');

        $departure_date = new \Illuminate\Support\Carbon( $tour->departure_date);
        $returning_date = new \Illuminate\Support\Carbon( $tour->returning_date);
        $difference = ($departure_date->diff($returning_date)->days);

        $tour->days = $difference;

        $tour_days = $tour->tour_days;

        return view('admin.dashboard.tour.profile',compact('tour','tour_days'));
    }

    public function setting()
    {
        return view('admin.dashboard.tour.setting.app');
    }

    public function indexTag()
    {
        $tags = Tag::all();
        return view('admin.dashboard.tour.setting.tag.index',compact('tags'));
    }

    public function createTag()
    {
        return view('admin.dashboard.tour.setting.tag.create');
    }

    public function storeTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:tags|regex:/^[a-zA-Z ]*$/'
        ],[],['name' => 'Tag Name']);


        $validator->validate();

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('popup_success', 'Tag Created');
    }

    public function editTag($slug)
    {
        $tag = Tag::where('slug','=',$slug)->first();
        abort_if($tag == null,'404','Tag not found');


        return view('admin.dashboard.tour.setting.tag.edit',compact('tag'));
    }

    public function updateTag(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z ]*$/'
        ],[],['name' => 'Tag Name']);


        $validator->validate();

        $tag = Tag::where('slug','=',$slug)->first();
        abort_if($tag == null,'404','Tag not found');

        if ($tag->name != $request->name)
        {
            $tag->name = $request->name;
            $tag->slug = Str::slug($request->name);
            $tag->save();
        }
        else{
            $validator->getMessageBag()->add('name', 'Name is already taken');
            return back()->withErrors($validator)->withInput();
        }

        return redirect('admin/dashboard/tour/setting/tag')->with('popup_success', 'Tag Updated');
    }

    public function destroyTag($slug)
    {
        $tag = Tag::where('slug','=',$slug)->first();
        abort_if($tag == null,'404','Tag not found');

        //Detach all tours
        $tag->tours()->detach();

        //Delete Tag

        $tag->delete();

        return back()->with('popup_success','Tag successfully deleted');
    }
}
