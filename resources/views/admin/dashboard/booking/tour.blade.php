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
                                    <a class="mt-3 btn btn-light" href="#searchs" data-toggle="collapse">Seaaaaaarch</a>
                                </div>
                                <div id="searchs" class="collapse">
                                    <hr>
                                    <form  id="search" method="GET" action="{{route('admin.dashboard.booking.tour.search')}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{-- Tour Name --}}
                                        <div class="col-12 col-md-6">
                                            <label for="departure_city" class=" form-control-label">Tour Name</label>
                                            <select name="tour_slug" id="select" class="form-control @error('tour_slug') is-invalid @enderror">
                                                <option value="">Select</option>
                                                @if(count($tours)>0)
                                                    @foreach($tours as $tour)
                                                        @if(old('tour_slug') == $tour->slug)
                                                            <option selected value="{{$tour->slug}}">{{$tour->name}}</option>
                                                        @else
                                                            <option value="{{$tour->slug}}">{{$tour->name}}</option>
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
                            <th>Order No.</th>
                            <th>Seats</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
                            <th>TRX ID</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($book_tours) > 0)
                            @foreach($book_tours as $book_tour)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th>{{$book_tour->number}}</th>
                                    <td>{{$book_tour->seats}}</td>
                                    <td>{{$book_tour->adults}}</td>
                                    <td>{{$book_tour->children}}</td>
                                    <td>{{$book_tour->phone}}</td>
                                    <td>
                                        <form id="status-form-{{$book_tour->number}}">
                                            @csrf
                                            <select onchange="submit_status_form('{{$book_tour->number}}')" name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\BookingStatus::toArray() as $status)
                                                    @if(old('status') ?? $book_tour->status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_tour->payment_type}}</td>
                                    <td>
                                        <form id="payment-status-form-{{$book_tour->number}}">
                                            @csrf
                                            <select onchange="submit_payment_status_form('{{$book_tour->number}}')" name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\PaymentStatus::toArray() as $status)
                                                    @if(old('payment_status') ?? $book_tour->payment_status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_tour->trxid ?? 'NULL'}}</td>
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
                            {{$book_tours->links()}}
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
                url:"/admin/dashboard/booking/"+number+"/tour/status/update",
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
                url:"/admin/dashboard/booking/"+number+"/tour/payment/status/update",
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
