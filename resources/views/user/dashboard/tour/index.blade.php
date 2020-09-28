@extends('layouts.dashboard')
@section('title','My Tours')
@section('tour','current')
@section('headerName', 'Tour')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-xl-12 col-12">
                            <h3 class="text-muted text-center mb-3">My Tours</h3>
                            <table class="table table-dark table-hover text-center">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Created at</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($tours) > 0)
                                    @foreach($tours as $tour)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <td>{{$tour->name}}</td>
                                            <td>{{$tour->slug}}</td>
                                            <td>{{$tour->created_at}}</td>
                                            <td>
                                                @if($tour->status == \App\Enums\Status::Active)
                                                    <span class="badge badge-success w-75 py-2">Avtive</span>
                                                @elseif($tour->status == \App\Enums\Status::InProgress)
                                                    <span class="badge badge-warning w-75 py-2">In progress</span>
                                                @elseif($tour->status == \App\Enums\Status::InActive)
                                                    <span class="badge badge-danger w-75 py-2">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline" role="group">
                                                    {{-- Profile Tour Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('profile-tour-{{$loop->iteration}}').submit();">
                                                        Profile
                                                    </a>
                                                    <form id="profile-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.profile',$tour->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Edit Blog Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('edit-tour-{{$loop->iteration}}').submit();">
                                                        Edit
                                                    </a>
                                                    <form id="edit-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.edit',$tour->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Delete Blog Button--}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-tour-{{$loop->iteration}}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="delete-tour-{{$loop->iteration}}" action="{{ route('dashboard.tour.delete',$tour->slug) }}" method="POST" style="display: none;">
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
