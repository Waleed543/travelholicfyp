@extends('layouts.dashboard')
@section('title','Hotel')
@section('Hotel','current')
@section('headerName', 'Hotels')
@section('content')
@section('css')
    <style>
        a{
            color: white;
        }
    </style>
@endsection


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
                                    <form  id="search" method="GET" action="{{route('dashboard.hotel.search')}}" enctype="multipart/form-data" class="form-horizontal">
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
                        </div>
                        <!-- Material form contact -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <h3 class="text-muted text-center mb-3">All Hotels</h3>
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
                        @if($hotels != null and count($hotels) > 0)
                            @foreach($hotels as $hotel)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td><a href="{{route('hotel.show',$hotel->slug)}}" target="_blank">{{$hotel->name}}</a></td>
                                    <td>{{$hotel->slug}}</td>
                                    <td>{{$hotel->created_at}}</td>
                                    <td> {{$hotel->status}}</td>

                                    <td>
                                        <div class="d-inline" role="group">
                                            {{-- Inactive Hotel Button--}}
                                            <a type="button" href="" class="btn btn-warning btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('inactive-hotel-{{$loop->iteration}}').submit();">
                                                Inavtive
                                            </a>
                                            <form id="inactive-hotel-{{$loop->iteration}}" action="{{ route('dashboard.hotel.status.inactive',$hotel->slug) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            {{-- Add Room Hotel Button--}}
                                            <a type="button" href="" class="btn btn-success btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('add-room-hotel-{{$loop->iteration}}').submit();">
                                                Rooms
                                            </a>
                                            <form id="add-room-hotel-{{$loop->iteration}}" action="{{route('dashboard.hotel.room.index',$hotel->slug)}}" method="POST" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            {{-- Edit Hotel Button--}}
                                            <a type="button" href="" class="btn btn-success btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('edit-hotel-{{$loop->iteration}}').submit();">
                                                Edit
                                            </a>
                                            <form id="edit-hotel-{{$loop->iteration}}" action="{{ route('dashboard.hotel.edit',$hotel->slug) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            {{-- Delete Hotel Button--}}
                                            <a type="button" href="" class="btn btn-danger btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('delete-hotel-{{$loop->iteration}}').submit();">
                                                Delete
                                            </a>
                                            <form id="delete-hotel-{{$loop->iteration}}" action="{{ route('hotel.destroy',$hotel->slug) }}" method="POST" style="display: none;">
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
                            <li class="page-item">
                                <a href="#" class="page-link py-2 px-3">
                                    <span>Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a href="#" class="page-link py-2 px-3">
                                    1
                                </a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link py-2 px-3">
                                    2
                                </a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link py-2 px-3">
                                    3
                                </a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link py-2 px-3">
                                    <span>Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- end of pagination -->
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@section('js')
    <script>
        function submit_status_form(slug) {
            var form = document.getElementById("status-form-"+slug);

            $.ajax({
                url:"/admin/dashboard/tour/"+slug+"/status",
                method:"POST",
                data:new FormData(form),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                error:function()
                {
                    alert('Status was unable to change');
                },
                success:function(data)
                {
                    show_message(data);
                }
            });
        }

    </script>
@endsection
@endsection
