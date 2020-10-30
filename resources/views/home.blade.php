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
        <a class="btn btn-outline-light btn-lg" href="#course">Book Tours</a>
    </div>
    <!--- Start Courese Section -->
    <div>
        <div class="col-12 narrow text-center">
            <h1>Customizable and reliable Tours</h1>
            <p class="lead">Book hotels, vehicles and restaurants</p>

        </div>
    </div>
    <!--- Start Course Section -->

    <script>
        $('#recipeCarousel').carousel({
            interval: 10000
        })

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

    <div class="container text-center my-3">
        <h2 class="font-weight-light">Bootstrap 4 - Multi Item Carousel</h2>
        <div class="row mx-auto my-auto">
            <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                <div class="carousel-inner w-100" role="listbox">
                    <div class="carousel-item active">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=1">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=2">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=3">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=4">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=5">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <img class="img-fluid" src="http://placehold.it/380?text=6">
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <h5 class="mt-2">Advances one slide at a time</h5>
    </div>

    <!--- Start Features Section -->
    <div>
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
    </div>
    <!--- End Features Section -->

    <!--- Start Resources Section -->
    <div >

        <div class="fixed-background">
            <div class="row dark text-center">
                <div class="col-12">
                    <h3 class="heading">Build With Care</h3>
                    <div class="heading-underline"></div>
                </div>

                <div class="col-md-4">
                    <h3>HTML 5</h3>
                    <div class="feature">
                        <i class="fas fa-code fa-3x"></i>
                    </div>
                    <p class="lead">This is dummy data.This is dummy data.This is dummy data.This is dummy data.</p>
                </div>

                <div class="col-md-4">
                    <h3>Bootstrap 4</h3>
                    <div class="feature">
                        <i class="fas fa-bold fa-3x"></i>
                    </div>
                    <p class="lead">This is dummy data.This is dummy data.This is dummy data.This is dummy data.</p>
                </div>

                <div class="col-md-4">
                    <h3>CSS 3</h3>
                    <div class="feature">
                        <i class="fab fa-css3 fa-3x"></i>
                    </div>
                    <p class="lead">This is dummy data.This is dummy data.This is dummy data.This is dummy data.</p>
                </div>

            </div><!--- End Row Dark Section -->

            <div class="fixed-wrap">
                <div class="fixed" style="background-image: url('{{asset('img/img1.jpeg')}}')">
                </div>
            </div>

        </div><!--- End Fixed Background Section -->

    </div>
    <!--- End Resources Section -->

    <!--- Start Clients Section -->

@endsection
