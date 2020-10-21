@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

<div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 700px; border-radius: 20px; color: #40474e">

    <div class="row">
        <div class="col-lg-3" style="height: 600px; background-color: white; padding: 0; margin-top: 3rem;margin-left: 2rem; border-radius: 20px">
            <h3 style="text-align: center; margin-top: 1rem">John Snow</h3>
            <div style="height: 300px; overflow-y: hidden;margin-bottom: 1.5rem" >
            <img style="width: 100%; margin-left: 0;" src={{asset('img/john.png')}}>
            </div>
            <div class="row" style="margin-bottom: 0;">
                <div class="col-lg-6">
            <label style=" margin-left: 1.5rem"><b>Gender:</b></label>
                </div>
                <label class="col-lg-6">Male</label>
            </div>

            <div class="row" style="">
                <div class="col-lg-6">
                    <label style=" margin-left: 1.5rem"><b>City:</b></label>
                </div>
                <label class="col-lg-6">Patoki</label>
            </div>
        </div>
        <div class="col-lg-8" style="height: 600px; background-color: white; padding: 0; margin-top: 3rem;margin-left: 2rem; border-radius: 20px">
            <div class="row" style="margin-top: 3rem">
                <div class="col-3" style="margin-left: 3.5rem">
                    <label style=" "><b>Total Blogs:</b></label>
                    <label>0</label>
                </div>
                <div class="col-3" style="">
                    <label style=" "><b>Tours Posted:</b></label>
                    <label>0</label>
                </div>

                <div class="col-3" style="">
                    <label style=""><b>Hotels added:</b></label>
                    <label>0</label>
                </div>

            </div>

            <div class="row" style="margin-top: 3rem; ">
                <div class="col-3" style="margin-left: 3.5rem">
                    <label style=" "><b>Vehicles added:</b></label>
                    <label>0</label>
                </div>
                <div class="col-3" style="">
                    <label style=" "><b>Bookings:</b></label>
                    <label>0</label>
                </div>

                <div class="col-4" style="">
                    <label style=""><b>Member Since:</b></label>
                    <label>The winter</label>
                </div>

            </div>
            <br>
            <br>
            <hr>
            <h3 style="text-align: center">Personal Info</h3>

            <div class="row" style="margin-top: 3rem">

                <div class="col-6" style="margin-left: 3.5rem">
                    <label style=" "><b>Address:</b></label>
                    <label>near attok petrol pump, Patoki</label>
                </div>


                <div class="col-5" style="">
                    <label style=""><b>Phone:</b></label>
                    <label>03334545921</label>
                </div>

            </div>


        </div>

    </div>

</div>






@endsection
