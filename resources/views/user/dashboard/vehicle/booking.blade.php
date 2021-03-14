@extends('layouts.dashboard')
@section('title','My Hotel Bookings')
@section('vehicle','current')
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
                                @if(count($user_vehicles) > 0)
                                    @foreach($user_vehicles as $user_vehicle)
                                        @if(count($user_vehicle->bookings) > 0)
                                            <tr class="bg-info">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user_vehicle->name}}</td>
                                            </tr>
                                            @foreach($user_vehicle->bookings as $booking)
                                                <tr>
                                                    <th>{{$loop->iteration}}</th>
                                                    <td>
                                                        @if($booking->vehicle != NULL)
                                                            <a class="btn btn-link" href="{{route('vehicle.show',$booking->vehicle->slug)}}">{{$booking->vehicle->name}}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{$booking->days}}</td>
                                                    <td>{{$booking->adults}}</td>
                                                    <td>{{$booking->children}}</td>
                                                    @foreach($cities as $city)
                                                        @if($city->id ==  $booking->departure_city)
                                                            @php
                                                                $departure_city = $city->name;
                                                            @endphp
                                                        @elseif($city->id ==  $booking->destination_city)
                                                            @php
                                                                $destination_city = $city->name;
                                                            @endphp
                                                        @endif

                                                    @endforeach
                                                    <td>{{$departure_city}}</td>
                                                    <td>{{$destination_city}}</td>
                                                    <td>{{date('d-M-Y', strtotime($booking->departure_date))}} at {{date('H:i', strtotime($booking->departure_date))}}</td>
                                                    <td>{{date('d-M-Y', strtotime($booking->returning_date))}} at {{date('H:i', strtotime($booking->returning_date))}}</td>
                                                    <td>
                                                        @if($booking->status == \App\Enums\BookingStatus::Reserved)
                                                            <span class="badge badge-danger w-85 py-2">Reserved</span>
                                                        @elseif($booking->status == \App\Enums\BookingStatus::Booked)
                                                            <span class="badge badge-success w-85 py-2">Booked</span>
                                                        @elseif($booking->status == \App\Enums\BookingStatus::Canceled)
                                                            <span class="badge badge-danger w-85 py-2">Canceled</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$booking->payment_type}}</td>
                                                    <td>
                                                        @if($booking->payment_status == \App\Enums\PaymentStatus::Unpaid)
                                                            <span class="badge badge-danger w-85 py-2">Unpaid</span>
                                                        @elseif($booking->payment_status == \App\Enums\PaymentStatus::UnderReview)
                                                            <span class="badge badge-warning w-85 py-2">Under Review</span>
                                                        @elseif($booking->payment_status == \App\Enums\PaymentStatus::Successful)
                                                            <span class="badge badge-success w-85 py-2">Successful</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($booking->trxid != NULL)
                                                            {{$booking->trxid}}
                                                        @else
                                                            Null
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a type="button" href="" class="btn btn-success btn-sm"
                                                               onclick="event.preventDefault();
                                                                   document.getElementById('book-{{$loop->iteration}}').submit();">
                                                                Confirm Booking
                                                            </a>
                                                            <form id="book-{{$loop->iteration}}" action="{{ route('dashboard.vehicle.book.booked',$booking->number) }}" method="POST" style="display: none;">
                                                                @method('GET')
                                                            </form>
                                                            <a type="button" href="" class="btn btn-danger btn-sm"
                                                               onclick="event.preventDefault();
                                                                   document.getElementById('cancel-{{$loop->iteration}}').submit();">
                                                                Cancel
                                                            </a>
                                                            <form id="cancel-{{$loop->iteration}}" action="{{ route('dashboard.vehicle.book.cancel',$booking->number) }}" method="POST" style="display: none;">
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
                                    {{$user_vehicles->links()}}
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
