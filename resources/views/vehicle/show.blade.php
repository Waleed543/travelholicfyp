@extends('layouts.app')
@section('nav','fixed-top')
@section('css-files')
    <link href="{{ asset('css/blog-single.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="landing">
        <div class="home-wrap">
            <div class="home-inner" style="background-image: url('{{asset('img/blog.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Vehicle</h1>
        <h3>Check Our Latest Vehicle</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Book Your own Vehicle</a>
    </div>
    <!--- Start Courese Section -->

    <!--- Start Courese Section -->
    <!--- Start Blog Section -->
    <div class="container-fluid">
        <div class="container">
            <div class="row welcome text-center">
                <div class="col-12">
                    <h1 class="display-4">Vehicle</h1>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="page-wrapper">
                    <div class="blog-title-area">
                        <div class="card blog-body" style="margin-left: 0">
                            <h3 class="search card-header white-text text-center py-4">{{$vehicle->name}}</h3>
                            <div class="card-body">
                                <div class="single-post-media">
                                    <img class="img-fluid" style="height :400px; width: 1000px;" src="{{asset('storage/'.$vehicle->user->username.'/vehicle/'.$vehicle->thumbnail)}}">
                                </div>
                                <br>
                                <div class="blog-content text-justify text-dark" style="max-width: 10000px" id="blog_content">
                                    <div class="row">

                                        <div  class="col-md-12" style="padding: 0">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black; color: white">
                                                    <strong class="card-title">Tour Information</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="card-text">Make : {{$vehicle->make}}</p>
                                                            <p class="card-text">Model : {{$vehicle->model}}</p>
                                                            <p class="card-text">Color : {{$vehicle->color}}</p>
                                                            <p class="card-text">Year : {{$vehicle->year}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="card-text">Price : {{$vehicle->price}}  per Day</p>
                                                            <p class="card-text">City : {{App\City::find($vehicle->city)->name}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div  class="col-md-12" style="padding: 0; padding-top: 15px">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black; color: white">
                                                    <strong class="card-title">About</strong>
                                                </div>
                                                <div class="card-body">
                                                    {!!$vehicle->description!!}
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div><!-- end content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card writer">
                    <!--Card content-->
                    @if($vehicle->user->profile->image != NULL)
                        <a href="{{route('show.user.profile',$vehicle->user->username)}}"><img src="{{asset('storage/'.$vehicle->user->username.'/profile_image/'.$vehicle->user->profile->image)}}" alt="John" style="width:100%"></a>
                    @else
                        <a href="{{route('show.user.profile',$vehicle->user->username)}}"><img src="{{asset('storage/temp/dummy_profile_pic.jpg')}}" class="img-thumbnail"></a>
                    @endif
                    <br>
                    <h1 style="text-transform: uppercase"> {{$vehicle->user->name}}</h1>
                    <p class="title">Vehicle Vendor</p>
                    <p>Total Vehicles = {{$vehicle->user->vehicles->count()}}</p>
                </div>
            </div>
        </div>
    </div>
    <!--- End Blog Section -->
    <script src="{{asset('js/blog-single.js')}}" type="text/javascript"></script>

@endsection
