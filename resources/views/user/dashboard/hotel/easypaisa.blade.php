@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

    <div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 900px; border-radius: 20px; color: #40474e">

        <div class="row">


            <div class="col-lg-12" style="height: 800px; background-color: white; padding: 0; margin-top: 3rem; border-radius: 20px">
                <div class="row" style="margin-top: 3rem">
                    <div class="col-lg-12">
                        <h4 style="text-align: center">Order ID: {{$book->number}}</h4>
                    </div>

                </div>

                <div class="row" style="margin-top: 3rem;">
                    <div class="col-3" style="margin-left: 5rem">
                        <label style=" "><b>Total cost:</b></label>
                        <label>{{$book->total_cost}}</label>
                    </div>
                    @php
                        $created = new \Illuminate\Support\Carbon($book->created_at);
                    @endphp
                    <div class="col-4" style="">
                        <label style=" "><b>Booking Time:</b></label>
                        <label>{{date('d-M-Y', strtotime($book->created_at))}} at {{$created->format('g:i A')}}</label>
                    </div>

                    <div class="col-4" style="">
                        <label style=""><b>Valid Till:</b></label>
                        <label>{{date('d-M-Y', strtotime($book->created_at))}} at {{$created->format('g')+2}}:{{$created->format('i A')}}</label>
                    </div>

                </div>
                <br>
                <br>
                <hr>
                <h3 style="text-align: center">Payment Details</h3>
                <div style="text-align: center">
                    <img src={{asset('img/epaisa.png')}}>
                </div>

                <div class="row">
                    <div class="col-lg-2"></div>

                    <div class="col-5" style="margin-left: 3.5rem">
                        <label style=" "><b>Account Name:</b></label>
                        <label>Zeeshan Khan</label>
                    </div>


                    <div class="col-4" style="">
                        <label style=""><b>Account ID:</b></label>
                        <label>03334545921</label>
                    </div>

                </div>
                <p style="text-align: center;color: #ff0000;">Note: After payment enter your TRX id provided by easypaisa by SMS in the feild below to confirm payment</p>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="reserve" method="post" action="{{route('dashboard.hotel.book.payment.store',$book->number)}}" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4" style="text-align: right"><label for="trxinput" class=" form-control-label"><h4>Trx ID:</h4></label></div>
                                <div class="col-lg-4">
                                    <input type="text" data-role="trxinput" id="blood" name="trxinput" value="{{old('trxinput')}}" class="form-control @error('trxinput') is-invalid @enderror">
                                    @error('trxinput')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror

                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary btn-sm" onkeypress="event.preventDefault();" value="submit" form="reserve">
                                        Submit
                                    </button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>






@endsection
