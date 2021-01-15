@extends('admin.dashboard.blog.setting.app')

@section('setting_content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row">
                        <div class="col-md-4 col-xl-12">
                            <h3 class="text-muted text-center mb-3">Blogs</h3>
                            <table class="table table-responsive table-dark table-hover text-center">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->created_at}}</td>
                                            <td>{{$category->updated_at}}</td>

                                            <td>
                                                <div class="d-inline" role="group">
                                                    {{-- Edit User Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('edit-{{$loop->iteration}}').submit();">
                                                        Edit
                                                    </a>
                                                    <form id="edit-{{$loop->iteration}}" action="{{ route('admin.dashboard.blog.setting.category.edit',$category->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Delete User Button--}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-{{$loop->iteration}}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="delete-{{$loop->iteration}}" action="{{ route('admin.dashboard.blog.setting.destroy.category',$category->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
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
@endsection
