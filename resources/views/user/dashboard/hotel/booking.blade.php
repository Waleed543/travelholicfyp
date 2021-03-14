@extends('layouts.dashboard')
@section('title','My Hotel Bookings')
@section('hotel','current')
@section('headerName', 'Booking')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-xl-12 col-12">
                            <h3 class="text-muted text-center mb-3">My Bookings</h3>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($user_hotels) > 0)
                                    @foreach($user_hotels as $user_hotel)
                                        @if(count($user_hotel->booking) > 0)
                                            <tr class="bg-info">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user_hotel->name}}</td>
                                            </tr>
                                            @foreach($user_hotel->booking as $booking)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$booking->hotel->name}}</td>
                                                    <td>{{$booking->room->name}}</td>
                                                    <td>{{$booking->total_rooms}}</td>
                                                    <td>{{$booking->adults}}</td>
                                                    <td>{{$booking->children}}</td>
                                                    <td>{{$booking->check_in_date}}</td>
                                                    <td>{{$booking->check_out_date}}</td>
                                                    <td>
                                                        @if($booking->status == \App\Enums\BookingStatus::Reserved)
                                                            <span class="badge badge-warning w-90 py-2">Reserved</span>
                                                        @elseif($booking->status == \App\Enums\BookingStatus::Booked)
                                                            <span class="badge badge-success w-90 py-2">Booked</span>
                                                        @elseif($booking->status == \App\Enums\BookingStatus::Canceled)
                                                            <span class="badge badge-danger w-90 py-2">Canceled</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$booking->payment_type}}</td>
                                                    <td>
                                                        @if($booking->payment_status == \App\Enums\PaymentStatus::Unpaid)
                                                            <span class="badge badge-danger w-75 py-2">Unpaid</span>
                                                        @elseif($booking->payment_status == \App\Enums\PaymentStatus::UnderReview)
                                                            <span class="badge badge-warning w-75 py-2">Under Review</span>
                                                        @elseif($booking->payment_status == \App\Enums\PaymentStatus::Successful)
                                                            <span class="badge badge-success w-75 py-2">Successful</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="d-inline" role="group">
                                                            <a type="button" href="" class="btn btn-success btn-sm"
                                                               onclick="event.preventDefault();
                                                                   submit_status_form('{{$booking->number}}')">
                                                                Confirm Booking
                                                            </a>
                                                            <form id="status-form-{{$booking->number}}"  name="status" id="status" style="display: none;">
                                                                @csrf
                                                                <input name="status" type="text" value="Booked">
                                                            </form>
                                                            <a type="button" href="" class="btn btn-danger btn-sm"
                                                               onclick="event.preventDefault();
                                                                   document.getElementById('cancel-hotel-{{$loop->iteration}}').submit();">
                                                                Cancel
                                                            </a>
                                                            <form id="cancel-hotel-{{$loop->iteration}}" action="{{ route('dashboard.hotel.book.cancel',$booking->number) }}" method="POST" style="display: none;">
                                                                @method('GET')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!-- pagination -->
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{$user_hotels->links()}}
                                </ul>
                            </nav>
                            <!-- end of pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of tables -->
@section('js')
    <script>
        function submit_status_form(number) {
            var form = document.getElementById("status-form-"+number);

            $.ajax({
                url:"/dashboard/hotel/bookings/"+number+"/status/update",
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
