@extends('layouts.dashboard')
@section('title','Hotel Book')
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
                                @if(count($bookings) > 0)
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
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
                                                    <span class="badge badge-danger w-80 py-2">Unpaid</span>
                                                @elseif($booking->payment_status == \App\Enums\PaymentStatus::UnderReview)
                                                    <span class="badge badge-warning w-80 py-2">Under Review</span>
                                                @elseif($booking->payment_status == \App\Enums\PaymentStatus::Successful)
                                                    <span class="badge badge-success w-80 py-2">Successful</span>
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
                                                    <a type="button" href="" class="btn btn-primary btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('add-trxid-{{$loop->iteration}}').submit();">
                                                        @if($booking->trxid != null) Update Trxid @else Add Trxid @endif
                                                    </a>
                                                    <form id="add-trxid-{{$loop->iteration}}" action="{{ route('dashboard.hotel.book.payment',$booking->number) }}" method="GET" style="display: none;">
                                                        @method('GET')
                                                    </form>
                                                     {{-- Delete Order Button --}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-hotel-{{$loop->iteration}}').submit();">
                                                        Cancel
                                                    </a>
                                                    <form id="delete-hotel-{{$loop->iteration}}" action="{{ route('dashboard.hotel.book.cancel',$booking->number) }}" method="POST" style="display: none;">
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
