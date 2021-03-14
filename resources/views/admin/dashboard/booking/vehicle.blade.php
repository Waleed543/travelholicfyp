@extends('admin.layouts.dashboardAdmin')
@section('title','Bookings')
@section('Booking','current')
@section('headerName', 'Tours Bookings')
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
                                    <form  id="search" method="GET" action="{{route('admin.dashboard.booking.vehicle.search')}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{-- Tour Name --}}
                                        <div class="col-12 col-md-6">
                                            <label for="vehicle_name" class=" form-control-label">Vehicle Name</label>
                                            <select name="vehicle_slug" id="select" class="form-control @error('vehicle_slug') is-invalid @enderror">
                                                <option value="">Select</option>
                                                @if(count($vehicles)>0)
                                                    @foreach($vehicles as $vehicle)
                                                        @if(old('vehicle_slug') == $vehicle->slug)
                                                            <option selected value="{{$vehicle->slug}}">{{$vehicle->name}}</option>
                                                        @else
                                                            <option value="{{$vehicle->slug}}">{{$vehicle->name}}</option>
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

                                        {{-- Order No --}}
                                        <div class="row form-group">
                                            <div class="col-12 col-md-6">
                                                <label for="order_no" class=" form-control-label">Order Number</label>
                                                <input type="number" id="order_no" name="order_no" value="{{old('order_no')}}" class="form-control @error('order_no') is-invalid @enderror">
                                                @error('order_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="phone_no" class=" form-control-label">Phone Number</label>
                                                <input type="number" id="phone_no" name="phone_no" value="{{old('phone_no')}}" class="form-control @error('phone_no') is-invalid @enderror">
                                                @error('phone_no')
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
                    <h3 class="text-muted text-center mb-3">All Tour Bookings</h3>
                    <table class="table table-dark table-hover text-center">
                        <thead>
                        <tr class="">
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Days</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Departure City</th>
                            <th>Destination City</th>
                            <th>Departure Date</th>
                            <th>Returning Date</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
                            <th>TrxId</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($book_vehicles) > 0)
                            @foreach($book_vehicles as $book_vehicle)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>
                                        @if($book_vehicle->vehicle != NULL)
                                            <a class="btn btn-link" href="{{route('tour.show',$book_vehicle->vehicle->slug)}}">{{$book_vehicle->vehicle->name}}</a>
                                        @endif
                                    </td>
                                    <td>{{$book_vehicle->days}}</td>
                                    <td>{{$book_vehicle->adults}}</td>
                                    <td>{{$book_vehicle->children}}</td>
                                    @foreach($cities as $city)
                                        @if($city->id ==  $book_vehicle->departure_city)
                                            @php
                                                $departure_city = $city->name;
                                            @endphp
                                        @elseif($city->id ==  $book_vehicle->destination_city)
                                            @php
                                                $destination_city = $city->name;
                                            @endphp
                                        @endif

                                    @endforeach
                                    <td>{{$departure_city}}</td>
                                    <td>{{$destination_city}}</td>
                                    <td>{{date('d-M-Y', strtotime($book_vehicle->departure_date))}} at {{date('H:i', strtotime($book_vehicle->departure_date))}}</td>
                                    <td>{{date('d-M-Y', strtotime($book_vehicle->returning_date))}} at {{date('H:i', strtotime($book_vehicle->returning_date))}}</td>



                                    <td>
                                        <form id="status-form-{{$book_vehicle->number}}">
                                            @csrf
                                            <select onchange="submit_status_form('{{$book_vehicle->number}}')" name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\BookingStatus::toArray() as $status)
                                                    @if(old('status') ?? $book_vehicle->status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_vehicle->payment_type}}</td>
                                    <td>
                                        <form id="payment-status-form-{{$book_vehicle->number}}">
                                            @csrf
                                            <select onchange="submit_payment_status_form('{{$book_vehicle->number}}')" name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\PaymentStatus::toArray() as $status)
                                                    @if(old('payment_status') ?? $book_vehicle->payment_status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_vehicle->trxid ?? 'NULL'}}</td>
                                    <td>
                                        <div class="d-inline" role="group">
                                            {{-- Delete Order Button --}}
                                            <a type="button" href="" class="btn btn-danger btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('delete-tour-{{$loop->iteration}}').submit();">
                                                Cancel
                                            </a>
                                            <form id="delete-tour-{{$loop->iteration}}" action="{{ route('admin.dashboard.booking.vehicle.cancel',$book_vehicle->number) }}" method="GET" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                        </div>
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <div class="d-inline" role="group">--}}
                                    {{--                                            --}}{{-- Add Room Hotel Button--}}
                                    {{--                                            <a type="button" href="" class="btn btn-success btn-sm"--}}
                                    {{--                                               onclick="event.preventDefault();--}}
                                    {{--                                                   document.getElementById('add-room-hotel-{{$loop->iteration}}').submit();">--}}
                                    {{--                                                Rooms--}}
                                    {{--                                            </a>--}}
                                    {{--                                            <form id="add-room-hotel-{{$loop->iteration}}" action="{{route('admin.dashboard.hotel.room.index',$hotel->slug)}}" method="POST" style="display: none;">--}}
                                    {{--                                                @csrf--}}
                                    {{--                                                @method('GET')--}}
                                    {{--                                            </form>--}}
                                    {{--                                            --}}{{-- Edit Tour Button--}}
                                    {{--                                            <a type="button" href="" class="btn btn-success btn-sm"--}}
                                    {{--                                               onclick="event.preventDefault();--}}
                                    {{--                                                   document.getElementById('edit-hotel-{{$loop->iteration}}').submit();">--}}
                                    {{--                                                Edit--}}
                                    {{--                                            </a>--}}
                                    {{--                                            <form id="edit-hotel-{{$loop->iteration}}" action="{{ route('admin.dashboard.hotel.edit',$hotel->slug) }}" method="POST" style="display: none;">--}}
                                    {{--                                                @csrf--}}
                                    {{--                                                @method('GET')--}}
                                    {{--                                            </form>--}}
                                    {{--                                            --}}{{-- Delete Tour Button--}}
                                    {{--                                            <a type="button" href="" class="btn btn-danger btn-sm"--}}
                                    {{--                                               onclick="event.preventDefault();--}}
                                    {{--                                                   document.getElementById('delete-tour-{{$loop->iteration}}').submit();">--}}
                                    {{--                                                Delete--}}
                                    {{--                                            </a>--}}
                                    {{--                                            <form id="delete-tour-{{$loop->iteration}}" action="{{ route('hotel.destroy',$hotel->slug) }}" method="POST" style="display: none;">--}}
                                    {{--                                                @csrf--}}
                                    {{--                                                @method('DELETE')--}}
                                    {{--                                            </form>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <!-- pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{$book_vehicles->links()}}
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
        function submit_status_form(number) {
            var form = document.getElementById("status-form-"+number);

            $.ajax({
                url:"/admin/dashboard/booking/"+number+"/vehicle/status/update",
                method:"POST",
                data:new FormData(form),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                error:function()
                {
                    alert('Status was unable to change: Error 100');
                },
                success:function(data)
                {
                    show_message(data);
                }
            });
        }
        function submit_payment_status_form(number) {
            var form = document.getElementById("payment-status-form-"+number);

            $.ajax({
                url:"/admin/dashboard/booking/"+number+"/vehicle/payment/status/update",
                method:"POST",
                data:new FormData(form),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                error:function()
                {
                    alert('Status was unable to change: Error 100');
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
