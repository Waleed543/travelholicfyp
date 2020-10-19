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
            <div class="home-inner" style="background-image: url('{{asset('img/blog.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Blogs</h1>
        <h3>Check Our Latest Blog</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Write Blog</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">

                <p class="lead">You will find all the tips and articles which will help you in tourism.</p>
                <a class="btn btn-secondary btn-md" href="{{route('admin.dashboard.blog.create')}}" target="_blank">Write Your Own Blog</a>
            </div>
        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Product Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row welcome text-center">
                    <div class="col-12">
                        <h1 class="display-4">Blogs</h1>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 search-card">
                <!-- Material form contact -->
                <div class="card search">
                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-0">
                        <div class="text-center">
                            <h1 class="mt-4">Search</h1>
                        </div>
                        <hr>
                        <form  id="search" method="get" action="{{route('blog.search')}}" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="name" class=" form-control-label">Name</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="category_id" class=" form-control-label">Category</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select name="category_id" id="select" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Please select</option>
                                        @if(count($categories)>0)
                                            @foreach($categories as $category)
                                                @if(old('category_id') == $category->id)
                                                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category_id')
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
                            @if(count($blogs) > 0)
                                @foreach($blogs as $blog)
                                    <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4">
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
                                @endforeach
                            @else
                                No Blogs Found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- End Product Section -->

@endsection
