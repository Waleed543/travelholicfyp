<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Facility;
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

        //Settings
        public function setting()
        {
            return view('admin.dashboard.hotel.setting.app');
        }

        public function indexFacility()
        {
            $facilities = Facility::all();
            return view('admin.dashboard.hotel.setting.facility.index',compact('facilities'));
        }

        public function createFacility()
        {
            return view('admin.dashboard.hotel.setting.facility.create');
        }

        public function storeFacility(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:tags|regex:/^[a-zA-Z ]*$/'
            ],[],['name' => 'Facility Name']);


            $validator->validate();

            $facility = Facility::firstOrCreate([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);

            return back()->with('popup_success', 'Facility Created');
        }

        public function editFacility($slug)
        {
            $facility = Facility::where('slug','=',$slug)->first();
            abort_if($facility == null,'404','Facility not found');


            return view('admin.dashboard.hotel.setting.facility.edit',compact('facility'));
        }

        public function updateFacility($slug, Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|regex:/^[a-zA-Z ]*$/'
            ],[],['name' => 'Tag Name']);


            $validator->validate();

            $facility = Facility::where('slug','=',$slug)->first();
            abort_if($facility == null,'404','Facility not found');

            if ($facility->name != $request->name)
            {
                $facility->name = $request->name;
                $facility->slug = Str::slug($request->name);
                $facility->save();
            }
            else{
                $validator->getMessageBag()->add('name', 'Name is already taken');
                return back()->withErrors($validator)->withInput();
            }

            return redirect('admin/dashboard/hotel/setting/facility')->with('popup_success', 'Facility Updated');
        }

        public function destroyFacility($slug)
        {
            $facility = Facility::where('slug','=',$slug)->first();
            abort_if($facility == null,'404','Facility not found');

            //Detach all tours
            $facility->rooms()->detach();

            //Delete Tag

            $facility->delete();

            return back()->with('popup_success','Facility successfully deleted');
        }
}
