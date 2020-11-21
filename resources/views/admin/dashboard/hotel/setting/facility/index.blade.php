@extends('admin.dashboard.hotel.setting.app')

@section('setting_content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row">
                        <div class="col-md-4 col-xl-12">
                            <h3 class="text-muted text-center mb-3">Facility</h3>
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
                                @if(count($facilities) > 0)
                                    @foreach($facilities as $facility)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <td>{{$facility->name}}</td>
                                            <td>{{$facility->created_at}}</td>
                                            <td>{{$facility->updated_at}}</td>

                                            <td>
                                                <div class="d-inline" role="group">
                                                    {{-- Edit User Button--}}
                                                    <a type="button" href="" class="btn btn-success btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('edit-role-{{$loop->iteration}}').submit();">
                                                        Edit
                                                    </a>
                                                    <form id="edit-role-{{$loop->iteration}}" action="{{ route('admin.dashboard.hotel.setting.facility.edit',$facility->slug) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('GET')
                                                    </form>
                                                    {{-- Delete User Button--}}
                                                    <a type="button" href="" class="btn btn-danger btn-sm"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('delete-role-{{$loop->iteration}}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{$loop->iteration}}" action="{{ route('admin.dashboard.hotel.setting.destroy.facility',$facility->slug) }}" method="POST" style="display: none;">
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
