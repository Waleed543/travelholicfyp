@extends('layouts.dashboard')
@section('title','Blog Create')
@section('blog','current')
@section('headerName', 'Create Blog')
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
                                    <strong>Create Blog</strong>
                                </div>
                                <div class="card-body card-block">
                                    <form  id="update" method="post" action="{{route('blog.store')}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="title" class=" form-control-label">Title</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="text" id="title" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" required>
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="inputContent" class=" form-control-label">Description</label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <textarea id="inputContent" name="body"class="form-control @error('body') is-invalid @enderror">{{old('body')}}</textarea>
                                                @error('body')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="select" class=" form-control-label">Category</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <select multiple name="categories[]" id="select" class="form-control @error('categories') is-invalid @enderror" required>
                                                    <option value="">Please select</option>
                                                    @if(count($categories)>0)
                                                        @foreach($categories as $category)
                                                            @if(old('categories')? in_array($category->id, old('categories')) :"")
                                                                <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                            @else
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endif
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
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="file-input" class=" form-control-label">Cover Image</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="file" id="file-input" name="file" class="form-control-file" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" value="submit" form="update">
                                        Create
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
