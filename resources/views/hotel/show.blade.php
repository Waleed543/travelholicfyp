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
        <h1>Tours</h1>
        <h3>Check Our Latest Tour</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Create Tour</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">
                <h1>All Blogs Related To Tourism</h1>
                <p class="lead">You will find all the tips and articles which will help you in tourism.</p>
                <a class="btn btn-secondary btn-md" href="#" target="_blank">Write Your Own Blog</a>
            </div>
        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Blog Section -->
    <div class="container-fluid">
        <div class="container">
            <div class="row welcome text-center">
                <div class="col-12">
                    <h1 class="display-4">Tour</h1>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="page-wrapper">
                    <div class="blog-title-area">
                        <div class="card blog-body" style="margin-left: 0">
                            <h3 class="search card-header white-text text-center py-4">{{$hotel->name}}</h3>
                            <div class="card-body">
                                <div class="single-post-media">
                                    <img class="img-fluid" style="height :400px; width: 1000px;" src="{{asset('storage/'.$hotel->user->username.'/tour/'.$hotel->thumbnail)}}">
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
                                                            <p class="card-text">Available Rooms : {{$hotel->available_rooms}}</p>
                                                            <p class="card-text">Remaining seats : {{$hotel->remaining_seats}}</p>
                                                            <p class="card-text">Price Per Person : {{$hotel->price}}</p>
                                                            <p class="card-text">Departure Dates: : {{date('d-M-Y', strtotime($hotel->departure_date))}} at {{date('H:i', strtotime($tour->departure_date))}}</p>
                                                            <p class="card-text">Returning Dates: : {{date('d-M-Y', strtotime($tour->returning_date))}} at {{date('H:i', strtotime($tour->returning_date))}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="card-text">Nights To Stay : {{$tour->nights_to_stay}} Nights</p>
                                                            <p class="card-text">Duration : {{$tour->days}} Days</p>
                                                            <p class="card-text">Departure City : {{App\City::find($tour->departure_city)->name}}</p>
                                                            <p class="card-text">Destination City : {{App\City::find($tour->destination_city)->name}}</p>
                                                            <p class="card-text">Price Per Person : {{$tour->price}}</p>
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
                                                    {!!$tour->description!!}
                                                </div>
                                            </div>
                                        </div>

                                        <div  class="col-md-12" style="padding: 0;padding-top: 15px">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black; color: white">
                                                    <strong class="card-title">Description</strong>
                                                </div>
                                                <div class="card-body">
                                                    @foreach($tour_days as $day)
                                                        <span class="badge badge-light">Day {{$day->number}}</span>
                                                        <p>
                                                        {!! $day->description !!}
                                                        <hr>
                                                        </p>
                                                    @endforeach

                                                    <span class="badge badge-success">Included</span>
                                                    <p>
                                                        -Food
                                                        -Stay
                                                        -Travel

                                                    </p>
                                                    <span class="badge badge-warning">Excluded</span>
                                                    <p>
                                                        -Camera

                                                    </p>


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
                    <img src="{{asset('storage/'.$tour->user->username.'/profile_image/'.$tour->user->profile->image)}}" alt="John" style="width:100%">
                    <br>
                    <h1>{{$tour->user->name}}</h1>
                    <p class="title">CEO & Founder, Example</p>
                    <p>Harvard University</p>
                    {{--                    <a href="#"><i class="fa fa-dribbble"></i></a>--}}
                    {{--                    <a href="#"><i class="fa fa-twitter"></i></a>--}}
                    {{--                    <a href="#"><i class="fa fa-linkedin"></i></a>--}}
                    {{--                    <a href="#"><i class="fa fa-facebook"></i></a>--}}
                </div>
            </div>
        </div>
    </div>
    <!--- End Blog Section -->
    <script src="{{asset('js/blog-single.js')}}" type="text/javascript"></script>

@endsection