<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Profile;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withTrashed()->paginate(15);

        return view('admin.dashboard.user.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.dashboard.user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email',
            'username' => 'required|string|max:255|regex:/^[a-zA-z]{4,}\d*$/',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|array',
        ]);

        $validator->validate();

        $user = new User();
        $user->name = $request->name;
        if($request->filled('email'))
        {
            $check = User::where('email' ,'=', $request->email)->where('id','<>',$user->id)->count();
            if($check == 0)
            {
                $user->email = $request->email;
            }
            else{
                $validator->getMessageBag()->add('email', 'Email is already taken');
            }
        }
        if($request->filled('username'))
        {
            $check = User::where('username' ,'=', $request->username)->where('id','<>',$user->id)->count();
            if($check == 0)
            {
                $user->username = $request->input('username');
            }
            else{
                $validator->getMessageBag()->add('username', 'Username is already taken');
            }
        }

        $user->password = Hash::make($request->password);

        if($validator->errors()->messages() != null)
        {
            return back()->withErrors($validator)->withInput();
        }


        $user->save();

        $user = User::find($user->username);
        //Create roles related to users
        $user->roles()->attach($request->role);
        //Create a profile for user
        $profile = new Profile();
        $user->profile()->save($profile);


        return back()->with('popup_success','User has been created');


    }

    public function edit($username)
    {
        if(is_string($username))
        {
            $user = User::findOrFail($username);
            $roles = Role::all();
            $user_roles = $user->roles->pluck('name')->toArray();

            return view('admin.dashboard.user.edit',compact('user','roles','user_roles'));
        }
    }

    public function update(Request $request,$username)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email',
            'username' => 'required|string|max:255|regex:/^[a-zA-z]{4,}\d*$/',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|array',
        ]);

        $validator->validate();

        $user = User::findOrFail($username);
        $user->name = $request->name;
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
        if($request->filled('email'))
        {
            $check = User::where('email' ,'=', $request->email)->where('id','<>',$user->id)->count();
            if($check == 0)
            {
                $user->email = $request->email;
                $user->email_verified_at = null;
            }
            else{
                $validator->getMessageBag()->add('email', 'Email is already taken');
                return back()->withErrors($validator)->withInput();
            }
        }
        if($request->filled('password'))
        {
            $user->password = Hash::make($request->password);
        }

        $user->force_logout = 1;

        $user->save();


        $user->roles()->sync($request->role);


        return back()->with('popup_success','User has been updated');
    }

    public function destroy($username)
    {
        $user = User::withTrashed()->findOrFail($username);
        if($user->trashed())
        {
            $user->forceDelete();
            return back()->with('popup_success','User has been permanently deleted');
        }
        $profile = $user->profile;
        if($profile->image != null)
        {
            Storage::delete('public/'.auth()->user()->username.'/profile_image/'.$profile->image);
        }
        $profile->delete();
        $user->roles()->detach();
        $user->delete();

        return back()->with('popup_success','User has been deleted');
    }

    public function setting()
    {
        return view('admin.dashboard.user.setting.app');
    }

    public function indexRole()
    {
        $roles = Role::all();
        return view('admin.dashboard.user.setting.index_role' ,compact('roles'));
    }

    public function createRole()
    {
        return view('admin.dashboard.user.setting.create_role');
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles|regex:/^[a-zA-Z ]*$/'
        ],[],['name' => 'Role Name']);


        $validator->validate();

        $role = Role::create([
            'name' => $request->name
        ]);

        return back()->with('popup_success', 'Role Created');

    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.dashboard.user.setting.edit_role',compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z ]*$/'
        ],[],['name' => 'Role Name']);


        $validator->validate();

        $role = Role::findOrFail($id);
        if($request->filled('name'))
        {
            $check = Role::where('name' ,'=', $request->name)->where('id','<>',$role->id)->count();
            if($check == 0)
            {
                $role->name = $request->name;
            }
            else{
                $validator->getMessageBag()->add('name', 'Role already exit');
                return back()->withErrors($validator)->withInput();
            }
        }
        $role->save();

        return back()->with('popup_success', 'Role has been updated');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        $role->users()->detach();

        $role->delete();

        return back()->with('popup_success', 'Roles has been deleted');
    }
}
