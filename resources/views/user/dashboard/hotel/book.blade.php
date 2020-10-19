@extends('layouts.dashboard')
@section('title','Book Create')
@section('tour','current')
@section('headerName', 'Book Tour')
@section('content')
    <!-- cards -->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Book</strong>
                                </div>
                                <div class="card-body card-block">
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
                                                <input type="number" id="children" name="children" value="{{old('children')}}" class="form-control @error('children') is-invalid @enderror" required>
                                                @error('children')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label><h3>Check In date</h3></label><br>
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
                                                <input type="number" id="total_rooms" name="total_rooms" value="{{old('total_rooms')}}" class="form-control @error('total_rooms') is-invalid @enderror" required>
                                                @error('total_rooms')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" value="submit" form="create">
                                        Book
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of cards -->

@endsection
