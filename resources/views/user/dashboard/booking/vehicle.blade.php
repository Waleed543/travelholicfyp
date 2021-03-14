@extends('layouts.dashboard')
@section('title','Vehcile Book')
@section('booking','current')
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
                                @if(count($bookings) > 0)
                                    @foreach($bookings as $booking)
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
                                                    <span class="badge badge-danger w-75 py-2">Reserved</span>
                                                @elseif($booking->status == \App\Enums\BookingStatus::Booked)
                                                    <span class="badge badge-success w-75 py-2">Booked</span>
                                                @elseif($booking->status == \App\Enums\BookingStatus::Canceled)
                                                    <span class="badge badge-danger w-75 py-2">Canceled</span>
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
                                                @if($booking->trxid != NULL)
                                                    {{$booking->trxid}}
                                                @else
                                                    Null
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-inline" role="group">
                                                     {{-- Delete Order Button --}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-hotel-{{$loop->iteration}}').submit();">
                                                        Cancel
                                                    </a>
                                                    <a type="button" href="" class="btn btn-primary btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('add-trxid-{{$loop->iteration}}').submit();">
                                                        @if($booking->trxid != null) Update Trxid @else Add Trxid @endif
                                                    </a>
                                                    <form id="delete-hotel-{{$loop->iteration}}" action="{{ route('dashboard.vehicle.book.cancel',$booking->number) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('POST')
                                                    </form>
                                                    <form id="add-trxid-{{$loop->iteration}}" action="{{ route('dashboard.vehicle.book.payment',$booking->number) }}" method="GET" style="display: none;">
                                                        @method('GET')
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
                                    {{$bookings->links()}}
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

@endsection
