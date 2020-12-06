@extends('admin.layouts.dashboardAdmin')
@section('title', 'Tour Setting')
@section('tour','current')
@section('headerName', 'Tour Setting')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3">
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card">
                                <a href="{{route('admin.dashboard.tour.setting.tag')}}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fas fa-users fa-3x text-info"></i>
                                            <div class="text-right text-secondary">
                                                <h5>List all</h5>
                                                <h3>Tags</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('admin.dashboard.tour.setting.create.tag')}}">
                                    <div class="card-footer text-secondary">
                                        <i class="fas fa-sync mr-3"></i>
                                        <span>Add New Tag</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @yield('setting_content')

@endsection
