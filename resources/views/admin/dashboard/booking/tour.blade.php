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
                                    <a class="mt-3 btn btn-light" href="#search" data-toggle="collapse">Search</a>
                                </div>
                                <div id="search" class="collapse">
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
                                    <td>{{$book_tour->trxid}}</td>
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
