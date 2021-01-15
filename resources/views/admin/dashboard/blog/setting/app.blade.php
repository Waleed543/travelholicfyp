@extends('admin.layouts.dashboardAdmin')
@section('title', 'Blog Setting')
@section('blog','current')
@section('headerName', 'Blog Setting')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3">
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card">
                                <a href="{{route('admin.dashboard.blog.setting.category')}}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fa fa-4x fa-th-list" aria-hidden="true"></i>
                                            <div class="text-right text-secondary">
                                                <h5>List all</h5>
                                                <h3>Categories</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('admin.dashboard.blog.setting.create.category')}}">
                                    <div class="card-footer text-secondary">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <span>Add New Categories</span>
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
