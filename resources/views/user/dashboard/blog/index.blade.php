@extends('layouts.dashboard')
@section('title','My Blogs')
@section('blog','current')
@section('headerName', 'Blog')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
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
                                                @if($blog->status == 'Approved')
                                                    <span class="badge badge-success w-75 py-2">Approved</span>
                                                @else
                                                    <span class="badge badge-warning w-75 py-2">In progress</span>
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
                                    <li class="page-item">
                                        <a href="#" class="page-link py-2 px-3">
                                            <span>Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link py-2 px-3">
                                            1
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link py-2 px-3">
                                            2
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link py-2 px-3">
                                            3
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link py-2 px-3">
                                            <span>Next</span>
                                        </a>
                                    </li>
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
