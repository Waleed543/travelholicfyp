@extends('admin.layouts.dashboardAdmin')
@section('title','Blog Setting')
@section('blog','current')
@section('headerName', 'Blog Setting')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Add Category</strong>
                                </div>
                                <div class="card-body card-block">
                                    <form  id="update" method="post" action="{{route('admin.dashboard.blog.setting.add.category')}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="name" class=" form-control-label">Name</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="name" name="name" value="@if(old('name')){{old('name')}}@endif" class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="select" class=" form-control-label">Parent Category</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <select name="category_id" id="select" class="form-control @error('category_id') is-invalid @enderror">
                                                    <option value="">Please select</option>
                                                    @if(count($categories)>0)
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" value="submit" form="update">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
