<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
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
        $cities = DB::table('city')->get();
        return view('user.dashboard.profile',compact('user','cities','profile'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'string|required|max:255|regex:/^[a-zA-Z ]*$/',
            'username'=>'string|required|max:255|regex:/^[a-zA-z]{4,}\d*$/',
            'number'=>'string|nullable',
            'address'=>'string|max:500|nullable',
            'city_id'=>'integer|nullable|exists:city,id',
            'gender_id'=>'integer|nullable',
        ]);

        $validator->validate();
        $user=auth()->user();
        $profile = $user->profile;
        if($request->filled('username'))
        {
            $check = User::where('username' ,'=', $request->username)->where('id','<>',$user->id)->count();
            if($check == 0)
            {
                $user->username = $request->input('username');
            }
            else{
                $validator->getMessageBag()->add('username', 'Username is already taken');
                return back()->withErrors($validator)->withInput();
            }
        }
        if($request->filled('name'))
        {
            $user->name = $request->input('name');
        }
        if($request->filled('number'))
        {
            $profile->number = $request->input('number');
        }
        if($request->filled('address'))
        {
            $profile->address = $request->input('address');
        }
        if($request->filled('city_id'))
        {
            $profile->city_id = $request->input('city_id');
        }
        if($request->filled('gender_id'))
        {
            $profile->gender = $request->input('gender_id') == '1' ? 'M':'F';
        }
        if($request->filled('phone'))
        {
            $profile->phone = $request->input('phone');
        }


        $profile->save();
        $user->save();

        return back()->with('popup_success', "Profile Updated");
    }

    public function updatePassword(Request $request)
    {
        $message = [
            'confirm_password.same' => 'Password does not match with new one',
        ];
        $validator = Validator::make($request->all(), [
            'current_password'=>'required|string|max:8',
            'new_password'=>'required|string|max:8',
            'confirm_password'=>'required|string|max:8|same:new_password',
        ],[],[
            'current_password' => 'Current Password',
            'new_password'=>'New Password',
            'confirm_password'=>'Confirm Password'
        ]);
        $validator->validate();

        $user = auth()->user();


        if (Hash::check($request->input('current_password'),auth()->user()->password))
        {
            if($request->input('current_password') == $request->input('new_password'))
            {
                $validator->getMessageBag()->add('new_password', 'Password cannnot be same as previous one');
                return back()->withErrors($validator);
            }
            if($request->filled('confirm_password')&&$request->filled('new_password'))
            {
                $user->password = Hash::make($request->input('new_password'));
            }
            $user->save();

            return back()->with('popup_success', "Password Updated");
        }

        $validator->getMessageBag()->add('current_password', 'Invalid Password');
        return back()->withErrors($validator);
    }

    public function updateImage(Request $request)
    {
        $this->validate($request,[
            'image'=>'image|required|max:1999'
        ]);

        if($request->hasFile('image'))
        {
            //get file name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //get file name
            $filename=pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension=$request->file('image')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('image')->storeAs(auth()->user()->username.'/profile_image/', $fileNameToStore,'public');

        }

        $user=auth()->user();
        $user_profile = $user->profile;
        if($request->hasFile('image'))
        {
            if($user_profile->image != null){
                Storage::delete('public/'.auth()->user()->username.'/profile_image/'.$user_profile->image);
            }
            $user_profile->image=$fileNameToStore;
        }
        $user_profile->save();

        return back()->with('popup_success', "Profile Picture Updated");
    }
}
