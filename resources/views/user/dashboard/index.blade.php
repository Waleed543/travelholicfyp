@extends('layouts.dashboard')
@section('title','')
@section('dashboard','current')
@section('headerName', 'DashBoard')
@section('content')
    <!-- cards -->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        @if($hotelcount > 0)
                            <div class="col-xl-3 col-sm-6 p-2">
                                <div class="card card-common">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fas fa-hotel fa-3x text-success"></i>
                                            <div class="text-right text-secondary">
                                                <h5>Total Active Hotels</h5>
                                                <h3>{{$hotelcount}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            @if($tourcount > 0)
                                <div class="col-xl-3 col-sm-6 p-2">
                                    <div class="card card-common">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <i class="fas fa-plane fa-3x text-warning"></i>
                                                <div class="text-right text-secondary">
                                                    <h5>Total Active Tours</h5>
                                                    <h3>{{$tourcount}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($vehiclecount > 0)
                                <div class="col-xl-3 col-sm-6 p-2">
                                    <div class="card card-common">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <i class="fas fa-truck-pickup fa-3x text-danger"></i>
                                                <div class="text-right text-secondary">
                                                    <h5>Total Active Vehicles</h5>
                                                    <h3>{{$vehiclecount}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of cards -->

    <!-- tables -->

    <!-- end of tables -->

    <!-- progress / task list -->

    <!-- end of activities / quick post -->
@endsection
