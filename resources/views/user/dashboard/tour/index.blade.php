@extends('layouts.dashboard')
@section('title','My Tours')
@section('tour','current')
@section('headerName', 'Tour')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3">
                        <div class="col-md-12 search-card">
                            <!-- Material form contact -->
                            <div class="card search">
                                <!--Card content-->
                                <div class="card-body px-lg-5 pt-0">
                                    <div class="text-center">
                                        <a class="mt-3 btn btn-light" href="#searchs" data-toggle="collapse">Search</a>
                                    </div>
                                    <div id="searchs" class="collapse">
                                        <hr>
                                        <form  id="search" method="GET" action="{{route('dashboard.tour.search')}}" enctype="multipart/form-data" class="form-horizontal">
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
                            </div>
                            <!-- Material form contact -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row mb-5">
                    <div class="col-xl-12 col-12">
                        <h3 class="text-muted text-center mb-3">My Tours</h3>
                        <table class="table table-dark table-hover text-center">
                            <thead>
                            <tr class="">
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($tours) > 0)
                                @foreach($tours as $tour)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <td>{{$tour->name}}</td>
                                        <td>{{$tour->slug}}</td>
                                        <td>{{$tour->created_at}}</td>
                                        <td>
                                            @if($tour->status == \App\Enums\Status::Active)
                                                <span class="badge badge-success w-75 py-2">Active</span>
                                            @elseif($tour->status == \App\Enums\Status::InProgress)
                                                <span class="badge badge-warning w-75 py-2">In progress</span>
                                            @elseif($tour->status == \App\Enums\Status::InActive)
                                                <span class="badge badge-danger w-75 py-2">InActive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-inline" role="group">
                                                {{-- Inactive Tour Button--}}
                                                <a type="button" href="" class="btn btn-warning btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('inactive-tour-{{$loop->iteration}}').submit();">
                                                    Inavtive
                                                </a>
                                                <form id="inactive-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.status.inactive',$tour->slug) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                {{-- Profile Tour Button--}}
                                                <a type="button" href="" class="btn btn-success btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('profile-tour-{{$loop->iteration}}').submit();">
                                                    Profile
                                                </a>
                                                <form id="profile-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.profile',$tour->slug) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                {{-- Edit Blog Button--}}
                                                <a type="button" href="" class="btn btn-success btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('edit-tour-{{$loop->iteration}}').submit();">
                                                    Edit
                                                </a>
                                                <form id="edit-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.edit',$tour->slug) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                {{-- Delete Blog Button--}}
                                                <a type="button" href="" class="btn btn-danger btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('delete-tour-{{$loop->iteration}}').submit();">
                                                    Delete
                                                </a>
                                                <form id="delete-tour-{{$loop->iteration}}" action="{{ route('tour.destroy',$tour->slug) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        <!-- pagination -->
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{ $tours->links() }}
                            </ul>
                        </nav>
                        <!-- end of pagination -->
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
