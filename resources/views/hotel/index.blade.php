@extends('layouts.app')
@section('nav','fixed-top')
@section('content')
    <style>
        .card img{
            height: 20rem;
        }
        .card{
            box-shadow: 20px 20px 15px grey;
        }
        .search{
            box-shadow: 20px 20px 50px 0px gray inset;
        }
    </style>
    <div class="landing">
        <div class="home-wrap">
            <div class="home-inner" style="background-image: url('{{asset('img/hotel.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Hotel</h1>
        <h3>Check Our Latest Hotel</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Hotel</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">

                <p class="lead">All the hotels posted by vendors.</p>

            </div>
        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Product Section -->
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
            <div class="col-sm-6 col-md-6 col-lg-4 search-card">
                <!-- Material form contact -->
                <div class="card ">
                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-0">
                        <div class="text-center">
                            <h1 class="mt-4">Search</h1>
                        </div>
                        <hr>
                        <form  id="search" method="GET" action="{{route('hotel.search')}}" enctype="multipart/form-data" class="form-horizontal">
                            @method('GET')
                            {{-- Name --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <label for="name" class=" form-control-label">Name</label>
                                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Rooms --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <label for="rooms" class=" form-control-label">Available Rooms</label>
                                    <input type="number" id="rooms" name="rooms" value="{{old('rooms')}}" class="form-control @error('rooms') is-invalid @enderror">
                                    @error('rooms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- City --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <label for="city" class=" form-control-label">City</label>
                                    <select name="city" id="select" class="form-control @error('city') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @if(count($cities)>0)
                                            @foreach($cities as $city)
                                                @if(old('city') == $city->id)
                                                    <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-sm" value="submit" form="search">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Material form contact -->
            </div>
            <div class="col-sm-6 col-md-6 col-lg-8">
                <div class="product">
                    <!--- Cards -->
                    <div class="container-fluid">
                        <div class="row">
                            @if(count($hotels ?? '') > 0)
                                @foreach($hotels ?? '' as $hotel)
                                    <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4">
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
                                @endforeach
                            @else
                                No Tours Found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- End Product Section -->

@endsection
