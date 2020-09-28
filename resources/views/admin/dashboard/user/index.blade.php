@extends('admin.layouts.dashboardAdmin')
@section('title','Users Setting')
@section('user','current')
@section('headerName', 'Users')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-md-4 col-xl-12">
                            <h3 class="text-muted text-center mb-3">Search</h3>
                            <table class="table table-responsive table-dark table-hover text-center">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Email Verified</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <td style="{{$user->deleted_at ? 'background-color:red;' :''}}">{{$user->name}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->email_verified_at ? $user->email_verified_at :'No'}}</td>
                                            <td>{{$user->created_at}}</td>

                                            <td>
                                                <div class="d-inline" role="group">
                                                    {{-- Edit User Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('edit-user-{{$loop->iteration}}').submit();">
                                                        Edit
                                                    </a>
                                                    <form id="edit-user-{{$loop->iteration}}" action="{{ route('admin.dashboard.user.edit',$user->username) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Delete User Button--}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                        document.getElementById('delete-user-{{$loop->iteration}}').submit();">
                                                        {{$user->deleted_at ? 'Permanent ' :''}} Delete
                                                    </a>
                                                    <form id="delete-user-{{$loop->iteration}}" action="{{ route('admin.dashboard.user.delete',$user->username) }}" method="POST" style="display: none;">
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
    <!-- end of tables -->

@endsection
