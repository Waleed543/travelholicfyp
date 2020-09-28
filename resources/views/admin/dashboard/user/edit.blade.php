@extends('admin.layouts.dashboardAdmin')
@section('title','User Edit')
@section('user','current')
@section('headerName', 'Edit User')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Edit User</strong>
                                </div>
                                <div class="card-body card-block">
                                    <form  id="update" method="post" action="{{route('admin.dashboard.user.update',$user->username)}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="name" class=" form-control-label">Name</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="text" id="name" name="name" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="username" class=" form-control-label">Username</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="text" id="username" name="username" value="{{$user->username}}" class="form-control @error('username') is-invalid @enderror" required>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="email" class=" form-control-label">Email</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="email" id="email" value="{{$user->email}}" name="email" class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="password" class=" form-control-label">New Password</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="password" id="password" value="" name="password" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="password-confirm" class=" form-control-label">Confirm Password</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="password" id="password-confirm" value="" name="password_confirmation" class="form-control @error('password-confirm') is-invalid @enderror">
                                                @error('password-confirm')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-2">
                                                <label for="role" class=" form-control-label">Role</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <select multiple name="role[]" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                                    <option value="">Please select</option>
                                                    @if(count($roles)>0)
                                                        @foreach($roles as $role)
                                                            @if(in_array($role->name,$user_roles))
                                                                <option selected value="{{$role->id}}">{{$role->name}}</option>
                                                            @else
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('role')
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
                                        Update
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
