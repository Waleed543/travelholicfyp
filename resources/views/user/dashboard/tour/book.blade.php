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
