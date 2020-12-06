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
            <div class="home-inner" style="background-image: url('{{asset('img/tour.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Tour</h1>
        <h3>Check Our Latest Tour</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Vehicle</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">

                <p class="lead">You will find all the tours here that are posted by either users or by us.</p>
                <a class="btn btn-secondary btn-md" href="{{route('admin.dashboard.tour.create')}}" target="_blank">Create tour</a>
            </div>
        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Product Section -->
    <div class="container-fluid">
        <div class="container">
            <div class="row welcome text-center">
                <div class="col-12">
                    <h1 class="display-4">Tours</h1>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 search-card">
                <!-- Material form contact -->
                <div class="card">
                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-0">
                        <div class="text-center">
                            <h1 class="mt-4">Search</h1>
                        </div>
                        <hr>
                        <form  id="search" method="GET" action="" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
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
                            {{-- Seats --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <label for="seats" class=" form-control-label">Seats</label>
                                    <input type="number" min="0" max="100" id="seats" name="seats" value="{{old('seats')}}" class="form-control @error('seats') is-invalid @enderror">
                                    @error('seats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Cities --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-6">
                                    <label for="departure_city" class=" form-control-label">Departure City</label>
                                    <select name="departure_city" id="select" class="form-control @error('departure_city') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @if(count($cities)>0)
                                            @foreach($cities as $city)
                                                @if(old('departure_city') == $city->id)
                                                    <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('departure_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="destination_city" class=" form-control-label">Destination City</label>
                                    <select name="destination_city" id="select" class="form-control @error('destination_city') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @if(count($cities)>0)
                                            @foreach($cities as $city)
                                                @if(old('destination_city') == $city->id)
                                                    <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('destination_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Price --}}
                            <div class="row form-group">
                                <div class="col-12 col-md-6">
                                    <label for="min_price" class=" form-control-label">Min Price</label>
                                    <input type="min_price" min="0" max="120000" id="min_price" name="min_price" value="{{old('min_price')  ?? 0}}" class="form-control @error('min_price') is-invalid @enderror">
                                    @error('min_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="max_price" class=" form-control-label">Max Pice</label>
                                    <input type="number" min="0" max="120000" id="max_price" name="max_price" value="{{old('max_price') ?? 120000}}" class="form-control @error('max_price') is-invalid @enderror">
                                    @error('max_price')
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
                            @if(count($vehicles) > 0)
                                @foreach($vehicles as $vehicle)
                                    <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4">
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
                                                <form id="book-{{$tour->slug}}" method="POST" action="{{route('dashboard.tour.book',$vehicle->slug)}}" class="d-none">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                <a type="button" href="{{route('vehicle.show',$vehicle->slug)}}" class="btn btn-outline-secondary">See More</a>
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
        <div class="row justify-content-center">
            {{$vehicles->links()}}
        </div>
    </div>
    <!--- End Product Section -->

@endsection
