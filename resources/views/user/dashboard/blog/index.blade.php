@extends('layouts.dashboard')
@section('title','My Blogs')
@section('blog','current')
@section('headerName', 'Blog')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3">
                        <div class="col-md-12 search-card">
                            <!-- Material form contact -->
                            <div class="card search">
                                <!--Card content-->
                                <div class="card-body px-lg-5 pt-0">
                                    <div class="text-center">
                                        <a class="mt-3 btn btn-light" href="#searchs" data-toggle="collapse">Search</a>
                                    </div>
                                    <div id="searchs" class="collapse">
                                        <hr>
                                        <form  id="search" method="GET" action="{{route('dashboard.blog.search')}}" enctype="multipart/form-data" class="form-horizontal">
                                            {{-- Name --}}
                                            <div class="row form-group">
                                                <div class="col-12 col-md-12">
                                                    <label for="name" class=" form-control-label">Name</label>
                                                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- Cities --}}
                                            <div class="row form-group">
                                                <div class="col-12 col-md-6">
                                                    <label for="category_id" class=" form-control-label">Category</label>
                                                    <select name="category_id" id="select" class="form-control @error('category_id') is-invalid @enderror">
                                                        <option value="">Select</option>
                                                        @if(count($categories)>0)
                                                            @foreach($categories as $category)
                                                                @if(old('category_id') == $category->id)
                                                                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                                @else
                                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('departure_city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-secondary btn-sm" value="submit" form="search">
                                                Search
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Material form contact -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row mb-5">
                        <div class="col-xl-12 col-12">
                            <h3 class="text-muted text-center mb-3">My Blogs</h3>
                            <table class="table table-dark table-hover text-center">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Created at</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($blogs) > 0)
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <td>{{$blog->title}}</td>
                                            <td>{{$blog->slug}}</td>
                                            <td>{{$blog->created_at}}</td>
                                            <td>
                                                @if($blog->status == \App\Enums\Status::Active)
                                                    <span class="badge badge-success w-75 py-2">Active</span>
                                                @elseif($blog->status == \App\Enums\Status::InProgress)
                                                    <span class="badge badge-warning w-75 py-2">In progress</span>
                                                @elseif($blog->status == \App\Enums\Status::InActive)
                                                    <span class="badge badge-danger w-75 py-2">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline" role="group">
                                                    {{-- Edit Blog Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('edit-blog-{{$loop->iteration}}').submit();">
                                                        Edit
                                                    </a>
                                                    <form id="edit-blog-{{$loop->iteration}}" action="{{ route('dashboard.blog.edit',$blog->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Delete Blog Button--}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-blog-{{$loop->iteration}}').submit();">
                                                       Delete
                                                    </a>
                                                    <form id="delete-blog-{{$loop->iteration}}" action="{{ route('dashboard.blog.delete',$blog->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!-- pagination -->
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{$blogs->links()}}
                                </ul>
                            </nav>
                            <!-- end of pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of tables -->
@endsection
