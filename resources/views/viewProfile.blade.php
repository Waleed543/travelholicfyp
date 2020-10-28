@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

<div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 700px; border-radius: 20px; color: #40474e">

    <div class="row">
        <div class="col-lg-3" style="height: 600px; background-color: white; padding: 0; margin-top: 3rem;margin-left: 2rem; border-radius: 20px">
            <h3 style="text-align: center; margin-top: 1rem">{{$user->name}}</h3>
            <div style="height: 300px; overflow-y: hidden;margin-bottom: 1.5rem" >
                @if($profile->image != NULL)
                    <img src="{{asset('storage/'.$user->username.'/profile_image/'.$profile->image)}}" class="img-thumbnail">
                @else
                    <img src="{{asset('storage/temp/dummy_profile_pic.jpg')}}" class="img-thumbnail">
                @endif
            </div>
            <div class="row" style="margin-bottom: 0;">
                <div class="col-lg-6">
            <label style=" margin-left: 1.5rem"><b>Gender:</b></label>
                </div>
                <label class="col-lg-6">{{$profile->gender}}</label>
            </div>

            <div class="row" style="">
                <div class="col-lg-6">
                    <label style=" margin-left: 1.5rem"><b>City:</b></label>
                </div>
                <label class="col-lg-6">@if($city != NULL){{$city->name}}@endif</label>
            </div>
        </div>
        <div class="col-lg-8" style="height: 600px; background-color: white; padding: 0; margin-top: 3rem;margin-left: 2rem; border-radius: 20px">
            <div class="row" style="margin-top: 3rem">
                <div class="col-3" style="margin-left: 3.5rem">
                    <label style=" "><b>Total Blogs: </b></label>
                    <label>{{$user->blogs->count()}}</label>
                </div>
                <div class="col-3" style="">
                    <label style=" "><b>Tours Posted:</b></label>
                    <label>{{$user->tours->count()}}</label>
                </div>

                <div class="col-3" style="">
                    <label style=""><b>Hotels added:</b></label>
                    <label>{{$user->hotels->count()}}</label>
                </div>

            </div>

            <div class="row" style="margin-top: 3rem; ">
                <div class="col-3" style="margin-left: 3.5rem">
                    <label style=" "><b>Vehicles added:</b></label>
                    <label>0</label>
                </div>

                <div class="col-6" style="">
                    <label style=""><b>Member Since:</b></label>
                    <label>{{$user->created_at}}</label>
                </div>

            </div>
            <br>
            <br>
            <hr>
            <h3 style="text-align: center">Personal Info</h3>

            <div class="row" style="margin-top: 3rem">

                <div class="col-6" style="margin-left: 3.5rem">
                    <label style=" "><b>Address:</b></label>
                    <label>{{$user->address}}</label>
                </div>


                <div class="col-5" style="">
                    <label style=""><b>Phone:</b></label>
                    <label>{{$user->phone}}</label>
                </div>

            </div>


        </div>

    </div>

</div>






@endsection
