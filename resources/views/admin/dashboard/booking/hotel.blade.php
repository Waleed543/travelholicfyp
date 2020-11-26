@extends('admin.layouts.dashboardAdmin')
@section('title','Hotel Bookings')
@section('Booking','current')
@section('headerName', 'Hotel Bookings')
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
                            <th>Hotel</th>
                            <th>Room Type</th>
                            <th>Total Rooms</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Check-In Date</th>
                            <th>Check-Out Date</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
                            <th>TrxId</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($book_hotels) > 0)
                            @foreach($book_hotels as $book_hotel)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$book_hotel->hotel->name}}</td>
                                    <td>{{$book_hotel->room->name}}</td>
                                    <td>{{$book_hotel->total_rooms}}</td>
                                    <td>{{$book_hotel->adults}}</td>
                                    <td>{{$book_hotel->children}}</td>
                                    <td>{{$book_hotel->check_in_date}}</td>
                                    <td>{{$book_hotel->check_out_date}}</td>
                                    <td>
                                        <form id="status-form-{{$book_hotel->number}}">
                                            @csrf
                                            <select onchange="submit_status_form('{{$book_hotel->number}}')" name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\BookingStatus::toArray() as $status)
                                                    @if(old('status') ?? $book_hotel->status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_hotel->payment_type}}</td>
                                    <td>
                                        <form id="payment-status-form-{{$book_hotel->number}}">
                                            @csrf
                                            <select onchange="submit_payment_status_form('{{$book_hotel->number}}')" name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                                                <option value="">Please select</option>
                                                @foreach(App\Enums\PaymentStatus::toArray() as $status)
                                                    @if(old('payment_status') ?? $book_hotel->payment_status == $status)
                                                        <option selected value="{{$status}}">{{$status}}</option>
                                                    @else
                                                        <option value="{{$status}}">{{$status}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{$book_hotel->trxid ?? 'NULL'}}</td>
                                    <td>
                                        <div class="d-inline" role="group">
                                            {{-- Delete Order Button --}}
                                            <a type="button" href="" class="btn btn-danger btn-sm"
                                               onclick="event.preventDefault();
                                                   document.getElementById('delete-tour-{{$loop->iteration}}').submit();">
                                                Delete
                                            </a>
                                            <form id="delete-tour-{{$loop->iteration}}" action="{{ route('admin.dashboard.booking.tour.delete',$book_hotel->number) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
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
                            {{$book_hotels->links()}}
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
                url:"/admin/dashboard/booking/"+number+"/hotel/status/update",
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
                url:"/admin/dashboard/booking/"+number+"/hotel/payment/status/update",
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
