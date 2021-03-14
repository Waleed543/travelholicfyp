@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

    <div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 900px; border-radius: 20px; color: #40474e">

        <div class="row">


            <div class="col-lg-12" style="height: 800px; background-color: white; padding: 0; margin-top: 3rem; border-radius: 20px">
                <div class="row" style="margin-top: 3rem">
                    <div class="col-lg-12">
                        <h4 style="text-align: center">Tour Details</h4>
                    </div>

                </div>

                <div class="row" style="margin-top: 3rem;">
                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Per Seat Cost: </b></label>
                        <label>{{$tour->price}}</label>
                    </div>
                    <div class="col-4" style="">
                        <label style=" "><b>Departure Date:</b></label>
                        <label>{{date('d-M-Y', strtotime($tour->departure_date))}} at {{date('H:i', strtotime($tour->departure_date))}}</label>
                    </div>

                    <div class="col-4" style="">
                        <label style=""><b>Posted by:</b></label>
                        <label>{{$tour->user->name}}</label>
                    </div>

                </div>
                <br>
                <br>
                <hr>
                <h3 style="text-align: center">Your Details</h3>


                <p style="text-align: center;color: #ff0000;">Note: Booking will not be valid until verified</p>
                <div class="row">
                    <div class="col-lg-12">
                        <form  id="create" method="post" action="{{route('dashboard.tour.book.store',$tour->slug)}}" enctype="multipart/form-data" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="seats" class="form-control-label"><h3>Total Seats</h3></label>
                                    <input type="number" id="seats" name="seats" value="{{old('seats')}}" class="form-control @error('seats') is-invalid @enderror" required>
                                    @error('seats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone" class="form-control-label"><h3>Phone</h3></label>
                                    <input type="text" id="phone" name="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="adults" class="form-control-label"><h3>Adults</h3></label>
                                    <input type="number" id="adults" name="adults" value="{{old('adults')}}" class="form-control @error('adults') is-invalid @enderror" required>
                                    @error('adults')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="children" class="form-control-label"><h3>Children</h3></label>
                                    <input type="text" id="children" name="children" value="{{old('children')}}" class="form-control @error('children') is-invalid @enderror" required>
                                    @error('children')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="payment_type" class="form-control-label"><h3>Payment Type</h3></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_type1" value="1">
                                        <label class="form-check-label" for="payment_type1">
                                            Easy Paisa
                                        </label>
                                        @error('payment_type')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                        @enderror
                                    </div>
                                    @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </form>
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-primary" onkeypress="event.preventDefault();" value="submit" form="create">
                                Submit
                            </button>
                        </div>


                    </div>
                </div>

            </div>

        </div>

    </div>






@endsection
