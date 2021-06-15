@extends('layouts.app')
@section('nav','fixed-top')
@section('content')
    <div class="landing">
        <div class="home-wrap">
            <div class="home-inner" style="background-image: url('{{asset('img/bg_1.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Welcome To TravelHolic</h1>
        <h3>Book Your Tour With Us</h3>
        <a class="btn btn-outline-light btn-lg" href="{{route('tour.index')}}">Book Tours</a>
    </div>
    <!--- Start Jumbotron Section -->
    <div class="jumbotron">
        <div class="narrow text-center">

            <div class="col-12">
                <h3 class="heading">Features</h3>
                <div class="heading-underline"></div>
            </div>

            <div class="row text-center">

                <div class="col-md-4">
                    <div class="feature">
                        <i class="fas fa-wrench fa-4x" data-fa-transform="shrink-3 up-5"></i>
                        <h3>Custom Tours</h3>
                        <p>Cant find a suitable tour? Customize the tour according to your need.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature">
                        <i class="fas fa-user-check fa-4x" data-fa-transform="shrink-4.5 up-4.5"></i>
                        <h3>Verified</h3>
                        <p>Everything is posted on the website after being verified by the admins.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature">
                        <i class="fab fa-blogger fa-4x" data-fa-transform="shrink-4 up-5"></i>
                        <h3>Blog</h3>
                        <p>Write your own stories about your tours.</p>
                    </div>
                </div>

            </div><!--- End Row Section -->

        </div><!--- End Narrow Section -->
    </div>
    <!--- End Jumbotron Section -->
    <!--- Start Resources Section -->
    <div >

        <div class="fixed-background">
            <div class="row dark text-center">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <h3>Numbers of User</h3>
                    <div class="feature">
                        <i class="fas fa-users fa-css3 fa-3x"></i>
                    </div>
                    <p class="lead">{{$users_count}}</p>
                </div>

                <div class="col-md-2">
                    <h3>Numbers of Blogs</h3>
                    <div class="feature">
                        <i class="fas fa-bold fa-3x"></i>
                    </div>
                    <p class="lead">{{$blogs_count}}</p>
                </div>

                <div class="col-md-2">
                    <h3>Numbers of Trips</h3>
                    <div class="feature">
                        <i class="fas fa-plane fa-3x"></i>
                    </div>
                    <p class="lead">{{$tours_count}}</p>
                </div>

                <div class="col-md-2">
                    <h3>Numbers of Hotels</h3>
                    <div class="feature">
                        <i class="fas fa-hotel fa-3x"></i>
                    </div>
                    <p class="lead">{{$hotels_count}}</p>
                </div>

                <div class="col-md-2">
                    <h3>Numbers of Vehicles</h3>
                    <div class="feature">
                        <i class="fas fa-truck-pickup fa-3x"></i>
                    </div>
                    <p class="lead">{{$vehicles_count}}</p>
                </div>

            </div><!--- End Row Dark Section -->

            <div class="fixed-wrap">
                <div class="fixed" style="background-image: url('{{asset('img/img1.jpeg')}}')">
                </div>
            </div>

        </div><!--- End Fixed Background Section -->

    </div>
    <!--- End Resources Section -->

    <!--- Start Blogs Section -->

    @if(count($blogs) > 0)
    <div class="container text-center my-3">
        <h2 class="font-weight-bold">Our Latest Blogs</h2>
        <div style=" width: 12rem" class="heading-underline"></div>
        <div class="row mx-auto my-auto">
            <div id="BlogCarousel" class="carousel slide w-100" data-ride="carousel">
                <div class="carousel-inner w-100" role="listbox">
                    @foreach($blogs as $blog)
                        <div class="carousel-item @if($loop->iteration == 1) active @endif">
                            <div class="col-md-4">
                                <div class="card">
                                    <img class="card-img-top" style="height: 15rem" src="{{asset('storage/'.$blog->user->username.'/blog/'.$blog->thumbnail)}}">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$blog->title}}</h4>
                                        <cite title="Source Title">{{$blog->user->name}}</cite>
                                    </div>
                                    <div class="card-footer text-right bg-transparent">
                                        <a type="button" href="{{route('blog.show',$blog->slug)}}" class="btn btn-outline-secondary">See More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev w-auto" href="#BlogCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next w-auto" href="#BlogCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    @endif
    <!--- Start Tours Section -->

    @if(count($tours) > 0)
        <div class="container text-center my-3">
            <h2 class="font-weight-bold mt-2">Our Latest Tours</h2>
            <div style=" width: 12rem" class="heading-underline"></div>
            <div class="row mx-auto my-auto">
                <div id="TourCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @foreach($tours as $tour)
                            <div class="carousel-item @if($loop->iteration == 1) active @endif">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" style="height: 15rem" src="{{asset('storage/'.$tour->user->username.'/tour/'.$tour->thumbnail)}}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$tour->name}}</h4>
                                            <cite title="Source Title">{{$tour->user->name}}</cite>
                                        </div>
                                        <div class="card-footer text-right bg-transparent">
                                            <a target="_blank" class="btn btn-outline-primary"
                                               onclick="document.getElementById('book-{{$tour->slug}}').submit();">
                                                Book
                                            </a>
                                            <form id="book-{{$tour->slug}}" method="POST" action="{{route('dashboard.tour.book',$tour->slug)}}" class="d-none">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            <a type="button" href="{{route('tour.show',$tour->slug)}}" class="btn btn-outline-secondary">See More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev w-auto" href="#TourCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#TourCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif


    @if(count($hotels) > 0)
        <div class="container text-center my-3">
            <h2 class="font-weight-bold mt-2">Our Latest Hotels</h2>
            <div style=" width: 12rem" class="heading-underline"></div>
            <div class="row mx-auto my-auto">
                <div id="HotelCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @foreach($hotels as $hotel)
                            <div class="carousel-item @if($loop->iteration == 1) active @endif">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" style="height: 15rem" src="{{asset('storage/'.$hotel->user->username.'/hotel/'.$hotel->thumbnail)}}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$hotel->name}}</h4>
                                            <cite title="Source Title">{{$hotel->user->name}}</cite>
                                        </div>
                                        <div class="card-footer text-right bg-transparent">
                                            <a type="button" href="{{route('hotel.show',$hotel->slug)}}" class="btn btn-outline-secondary">See More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev w-auto" href="#HotelCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#HotelCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if(count($vehicles) > 0)
        <div class="container text-center my-3">
            <h2 class="font-weight-bold mt-2">Our Latest Vehicles</h2>
            <div style=" width: 12rem" class="heading-underline"></div>
            <div class="row mx-auto my-auto">
                <div id="VehicleCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @foreach($vehicles as $vehicle)
                            <div class="carousel-item @if($loop->iteration == 1) active @endif">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" style="height: 15rem" src="{{asset('storage/'.$vehicle->user->username.'/vehicle/'.$vehicle->thumbnail)}}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$vehicle->name}}</h4>
                                            <cite title="Source Title">{{$vehicle->user->name}}</cite>
                                        </div>
                                        <div class="card-footer text-right bg-transparent">
                                            <a target="_blank" class="btn btn-outline-primary"
                                               onclick="document.getElementById('book-{{$vehicle->slug}}').submit();">
                                                Book
                                            </a>
                                            <form id="book-{{$vehicle->slug}}" method="POST" action="{{route('dashboard.vehicle.book',$vehicle->slug)}}" class="d-none">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            <a type="button" href="{{route('vehicle.show',$vehicle->slug)}}" class="btn btn-outline-secondary">See More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev w-auto" href="#VehicleCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#VehicleCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!--- Start Clients Section -->

@endsection
@section('js_bottom')
    <script>

        $('#TourCarousel').carousel({
            interval: 8000
        });
        $('#BlogCarousel').carousel({
            interval: 7500
        });

        $('.carousel .carousel-item').each(function(){
            var minPerSlide = 3;
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i=0;i<minPerSlide;i++) {
                next=next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }

                next.children(':first-child').clone().appendTo($(this));
            }
        });

    </script>
@endsection
@section('css_top')
    <style>
        @media (max-width: 768px) {
            .carousel-inner .carousel-item > div {
                display: none;
            }
            .carousel-inner .carousel-item > div:first-child {
                display: block;
            }
        }

        .carousel-inner .carousel-item.active,
        .carousel-inner .carousel-item-next,
        .carousel-inner .carousel-item-prev {
            display: flex;
        }

        /* display 3 */
        @media (min-width: 768px) {

            .carousel-inner .carousel-item-right.active,
            .carousel-inner .carousel-item-next {
                transform: translateX(33.333%);
            }

            .carousel-inner .carousel-item-left.active,
            .carousel-inner .carousel-item-prev {
                transform: translateX(-33.333%);
            }
        }

        .carousel-inner .carousel-item-right,
        .carousel-inner .carousel-item-left{
            transform: translateX(0);
        }


    </style>
@endsection
