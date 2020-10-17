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
        <h1>Hotels</h1>
        <h3>Check Our Deals for hotels</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Create Hotel</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">

        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Blog Section -->
    <div class="container-fluid">
        <div class="container">
            <div class="row welcome text-center">
                <div class="col-12">
                    <h1 class="display-4">Hotel</h1>
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
                                    <img class="img-fluid" style="height :400px; width: 1000px;" src="{{asset('storage/'.$hotel->user->username.'/hotel/'.$hotel->thumbnail)}}">
                                </div>
                                <br>
                                <div class="blog-content text-justify text-dark" style="max-width: 10000px" id="blog_content">
                                    <div class="row">

                                        <div  class="col-md-12" style="padding: 0">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black; color: white">
                                                    <strong class="card-title">Hotel Information</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="card-text">Available Rooms : {{$hotel->available_rooms}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="card-text">City : {{App\City::find($hotel->city)->name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="card-text">Total Rooms : {{$hotel->total_rooms}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="card-text">Status : {{$hotel->status}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="card-text">Created on : {{$hotel->created_at}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="card-text">Last updated : {{$hotel->updated_at}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div  class="col-md-12" style="padding: 0; padding-top: 15px">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black; color: white">
                                                    <strong class="card-title">Description</strong>
                                                </div>
                                                <div class="card-body">
                                                    {!!$hotel->description!!}
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-md-12" style="padding: 0; padding-top: 15px">
                                            <div  class="card" style="margin-left: 0">
                                                <div class="card-header" style="background-color: black">
                                                    <strong class="card-title" style="color: white">Rooms</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <div class="row">
                                                                <div class="card col-md-3 " style="margin-left: 3.5rem">
                                                                    <div class="card-header" style="background-color: grey;">
                                                                        <strong class="card-title">Room 1</strong>

                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h1>sdafasdfasdf</h1>
                                                                    </div>
                                                                </div>

                                                                <div class="card col-md-3" style="margin-left: 3.5rem">
                                                                    <div class="card-header" style="background-color: grey;">
                                                                        <strong class="card-title">Room 2</strong>

                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h1>sdafasdfasdf</h1>
                                                                    </div>
                                                                </div>

                                                                <div class="card col-md-3 " style="margin-left: 3.5rem">
                                                                    <div class="card-header" style="background-color: grey;">
                                                                        <strong class="card-title">Room 3</strong>

                                                                    </div>
                                                                    <div class="card-body">
                                                                        <h1>sdafasdfasdf</h1>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="carousel-item">
                                                                <div class="row">
                                                                    <div class="card col-md-3 " style="margin-left: 3.5rem">
                                                                        <div class="card-header" style="background-color: grey;">
                                                                            <strong class="card-title">Room 4</strong>

                                                                        </div>
                                                                        <div class="card-body">
                                                                            <h1>sdafasdfasdf</h1>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card col-md-3" style="margin-left: 3.5rem">
                                                                        <div class="card-header" style="background-color: grey;">
                                                                            <strong class="card-title">Room 5</strong>

                                                                        </div>
                                                                        <div class="card-body">
                                                                            <h1>sdafasdfasdf</h1>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card col-md-3 " style="margin-left: 3.5rem">
                                                                        <div class="card-header" style="background-color: grey;">
                                                                            <strong class="card-title">Room 6</strong>

                                                                        </div>
                                                                        <div class="card-body">
                                                                            <h1>sdafasdfasdf</h1>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                           <i class="fa fa-chevron-circle-left fa-2x" aria-hidden="true" style="color: black"></i>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                            <i class="fa fa-chevron-circle-right fa-2x" aria-hidden="true" style="color: black"></i>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
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
                    <img src="{{asset('storage/'.$hotel->user->username.'/profile_image/'.$hotel->user->profile->image)}}" alt="John" style="width:100%">
                    <br>
                    <h1>{{$hotel->user->name}}</h1>
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
