@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

    <div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 900px; border-radius: 20px; color: #40474e">

        <div class="row">


            <div class="col-lg-12" style="height: 800px; background-color: white; padding: 0; margin-top: 3rem; border-radius: 20px">
                <div class="row" style="margin-top: 3rem">
                    <div class="col-lg-12">
                        <h4 style="text-align: center">Hotel Details</h4>
                    </div>

                </div>

                <div class="row" style="margin-top: 3rem;">

                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Hotel Name: </b></label>
                        <label>{{$hotel->name}}</label>
                    </div>
                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Room Type: </b></label>
                        <label>{{$room->name}}</label>
                    </div>

                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Capacity: </b></label>
                        <label>{{$room->capacity}}</label>
                    </div>


                </div>
                <div class="row">


                    <div class="col-3" style="margin-left: 5rem">
                        <label style=""><b>Price Per Room :</b></label>
                        <label>{{$room->price}}</label>
                    </div>
                    <div class="col-3" style="margin-left: 5rem">
                        <label style=""><b>Available Rooms :</b></label>
                        <label>{{$room->available}}</label>
                    </div>


                </div>
                <br>
                <br>
                <hr>
                <h3 style="text-align: center">Your Details</h3>


                <p style="text-align: center;color: #ff0000;">Note: Booking will not be valid until verified</p>
                <div class="row">
                    <div class="col-lg-12">
                        <form  id="create" method="post" action="{{route('dashboard.hotel.book.store',[$hotel->slug,$room->slug])}}" enctype="multipart/form-data" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="adults" class="form-control-label"><h3>Total Adults</h3></label>
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
                                    <label><h3>Check Out date</h3></label><br>
                                    <input type="date" name="check_in_date" value="{{old('check_in_date')}}" style="width: 100%" class="form-control @error('check_in_date')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                        <strong><i class="fas fa-exclamation-triangle"></i> @error('check_in_date'){{$message}} @enderror</strong>
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <label><h3>Check Out date</h3></label><br>
                                    <input type="date" name="check_out_date" value="{{old('check_out_date')}}" style="width: 100%" class="form-control @error('check_out_date')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                        <strong><i class="fas fa-exclamation-triangle"></i> @error('check_out_date'){{$message}} @enderror</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="total_rooms" class="form-control-label"><h3>Total Rooms</h3></label>
                                    <input type="text" id="total_rooms" name="total_rooms" value="{{old('total_rooms')}}" class="form-control @error('total_rooms') is-invalid @enderror" required>
                                    @error('total_rooms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="payment_type" class="form-control-label"><h3>Payment Type</h3></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_type1" value="1">
                                        <label class="form-check-label" for="payment_type1">
                                            Easy Paisa
                                        </label>
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
