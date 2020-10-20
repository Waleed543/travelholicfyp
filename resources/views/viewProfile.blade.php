@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

<div class="container" style="margin-top: 10rem; background-color: lightgrey; height: 900px; border-radius: 20px; color: #40474e">

    <div class="row">
        <div class="col-lg-3" style="height: 600px; background-color: white; padding: 0; margin-top: 3rem;margin-left: 2rem; border-radius: 20px">
            <h3 style="text-align: center; margin-top: 1rem">John Snow</h3>
            <div style="height: 300px; overflow-y: hidden">
            <img style="width: 100%; margin-left: 0;" src={{asset('img/john.png')}}>
            </div>
            <div class="row">
            <label class="col-lg-6" style="">Gender</label>
            </div>

        </div>


    </div>

</div>






@endsection
