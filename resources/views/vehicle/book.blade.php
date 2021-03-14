@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

    <div class="container" style="margin-top: 10rem; background-color: lightgrey;  border-radius: 20px; color: #40474e">

        <div class="card">


            <div class="col-lg-12" style="height: 800px; background-color: white; padding: 0; margin-top: 3rem; border-radius: 20px">
                <div class="row" style="margin-top: 3rem">
                    <div class="col-lg-12">
                        <h4 style="text-align: center">Vehicle Details</h4>
                    </div>

                </div>

                <div class="row" style="margin-top: 3rem;">
                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Per Day Cost: </b></label>
                        <label>{{$vehicle->price}}</label>
                    </div>
                    <div class="col-4" style="">
                        <label style=" "><b>Departure Date:</b></label>
                        <label></label>
                    </div>

                    <div class="col-4" style="">
                        <label style=""><b>Owner/Driver:</b></label>
                        <label>{{$vehicle->user->name}}</label>
                    </div>

                </div>
                <br>
                <br>
                <hr>
                <h3 style="text-align: center">Your Details</h3>


                <p style="text-align: center;color: #ff0000;">Note: Booking will not be valid until verified</p>
                <div class="row">
                    <div class="col-lg-12">
                        <form  id="create" method="post" action="{{route('dashboard.vehicle.book.store',$vehicle->slug)}}" enctype="multipart/form-data" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="row form-group">
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
                                    <label for="destination_city" class=" form-control-label"><h3>Destination City</h3></label>
                                    <select name="destination_city" id="destination_city" class="form-control @error('destination_city') is-invalid @enderror" required>
                                        <option value="">Please select</option>
                                        @if(count($cities)>0)
                                            @foreach($cities as $city)
                                                @if(old('destination_city') == $city->id)
                                                    <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('destination_city')
                                    <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="departure_city" class=" form-control-label"><h3>Departure City</h3></label>
                                    <select name="departure_city" id="departure_city" class="form-control @error('departure_city') is-invalid @enderror" required>
                                        <option value="">Please select</option>
                                        @if(count($cities)>0)
                                            @foreach($cities as $city)
                                                @if(old('departure_city') == $city->id)
                                                    <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
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
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label><h3>Departure date</h3></label><br>
                                    <input id="test" type="text" name="departure_date" min="{{$date_today}}" value="{{old('departure_date')}}" style="width: 100%" class="date form-control @error('departure_date')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                                  <strong><i class="fas fa-exclamation-triangle"></i> @error('departure_date'){{$message}} @enderror</strong>
                                                </span>
                                </div>
                                <div class="col-lg-6">
                                    <label><h3>Departure Time</h3></label><br>
                                    <input type="time" name="departure_time" value="{{old('departure_time')}}" style="width: 100%" class="form-control @error('departure_time')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                                  <strong><i class="fas fa-exclamation-triangle"></i> @error('departure_time'){{$message}} @enderror</strong>
                                                </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label><h3>Returning date</h3></label><br>
                                    <input type="date" name="returning_date" value="{{old('returning_date')}}" style="width: 100%" class="form-control @error('returning_date')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                                  <strong><i class="fas fa-exclamation-triangle"></i> @error('returning_date'){{$message}} @enderror</strong>
                                                </span>
                                </div>
                                <div class="col-lg-6">
                                    <label><h3>Returning Time</h3></label><br>
                                    <input type="time" name="returning_time" value="{{old('returning_time')}}" style="width: 100%" class="form-control @error('returning_time')is-invalid @enderror">
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                                  <strong><i class="fas fa-exclamation-triangle"></i> @error('returning_time'){{$message}} @enderror</strong>
                                                </span>
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
                                    </div>
                                    <span class="invalid-feedback alert alert-danger" role="alert" >
                                                  <strong><i class="fas fa-exclamation-triangle"></i> @error('payment_type'){{$message}} @enderror</strong>
                                                </span>
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

@section('js_bottom')
    <link href="http://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript">
        var array = @json($booking_dates);
        $('#test').datepicker({
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                return [ array.indexOf(string) == -1 ]
            }
        });
    </script>
@endsection
