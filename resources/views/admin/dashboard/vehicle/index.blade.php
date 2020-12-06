@extends('admin.layouts.dashboardAdmin')
@section('title','Vehicle')
@section('vehicle','current')
@section('headerName', 'Vehicles')
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
                                    <form  id="search" method="GET" action="{{route('admin.dashboard.tour.search')}}" enctype="multipart/form-data" class="form-horizontal">
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
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <h3 class="text-muted text-center mb-3">All Tours</h3>
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
                        @if(count($vehicles) > 0)
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td><a href="{{route('tour.show',$tour->slug)}}" target="_blank">{{$tour->name}}</a></td>
                                    <td>{{$tour->slug}}</td>
                                    <td>{{$tour->created_at}}</td>
                                    <td>
                                        <form id="status-form-{{$tour->slug}}">
                                            @csrf
                                            <select onchange="submit_status_form('{{$tour->slug}}')" name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\Status::toArray() as $status)
                                                    @if(old('status') ?? $tour->status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-inline" role="group">
                                            {{-- Profile Tour Button--}}
                                            <a type="button" href="" class="btn btn-success btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('profile-tour-{{$loop->iteration}}').submit();">
                                                Profile
                                            </a>
                                            <form id="profile-tour-{{$loop->iteration}}" action="{{ route('admin.dashboard.tour.profile',$tour->slug) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            {{-- Edit Tour Button--}}
                                            <a type="button" href="" class="btn btn-success btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('edit-tour-{{$loop->iteration}}').submit();">
                                                Edit
                                            </a>
                                            <form id="edit-tour-{{$loop->iteration}}" action="{{ route('admin.dashboard.tour.edit',$tour->slug) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                            {{-- Delete Tour Button--}}
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
                            {{$tours->links()}}
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
        function show_message(data)
        {
            alert(data.message);
        }

    </script>
@endsection
@endsection
