@extends('layouts.dashboard')
@section('title','My Rooms')
@section('hotel','current')
@section('headerName', 'Hotel')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3">
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card">
                                <a href="">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fas fa-users fa-3x text-info"></i>
                                            <div class="text-right text-secondary">
                                                <h5>Total Rooms Type = {{count($rooms)}}</h5>
                                                <h3>Rooms</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('dashboard.hotel.room.create',$slug)}}">
                                    <div class="card-footer text-secondary">
                                        <i class="fas fa-sync mr-3"></i>
                                        <span>Add New Room Type</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <h3 class="text-muted text-center mb-3">All Rooms</h3>
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
                            @if(count($rooms) > 0)
                                @foreach($rooms as $room)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <td>{{$room->name}}</td>
                                        <td>{{$room->slug}}</td>
                                        <td>{{$room->created_at}}</td>
                                        <td>
                                            <form id="status-form-{{$room->slug}}">
                                                @csrf
                                                <select onchange="submit_status_form('{{$hotel->slug}}','{{$room->slug}}')" name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                    <option value="">Please select</option>
                                                    @foreach(App\Enums\Status::toArray() as $status)
                                                        @if(old('status') ?? $room->status == $status)
                                                            <option selected value="{{$status}}">{{$status}}</option>
                                                        @else
                                                            <option value="{{$status}}">{{$status}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-inline" role="group">
                                                {{-- Edit Room Button--}}
                                                <a type="button" href="" class="btn btn-success btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('edit-hotel-{{$loop->iteration}}').submit();">
                                                    Edit
                                                </a>
                                                <form id="edit-hotel-{{$loop->iteration}}" action="{{ route('dashboard.hotel.room.edit',[$slug,$room->slug]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                {{-- Delete Tour Button--}}
                                                <a type="button" href="" class="btn btn-danger btn-sm"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('delete-tour-{{$loop->iteration}}').submit();">
                                                    Delete
                                                </a>
                                                <form id="delete-tour-{{$loop->iteration}}" action="{{ route('room.destroy',[$slug,$room->slug]) }}" method="POST" style="display: none;">
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
    </section>
    <!-- end of tables -->

@section('js')
    <script>
        function submit_status_form(hotel_slug, room_slug) {
            var form = document.getElementById("status-form-"+room_slug);

            $.ajax({
                url:"/dashboard/hotel/"+hotel_slug+"/room/"+room_slug+"/status/update",
                method:"POST",
                data:new FormData(form),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                error:function()
                {
                    alert('Status was unable to change');
                },
                success:function(data)
                {
                    show_message(data);
                }
            });
        }
        function show_message(data)
        {
            alert(data.message);
        }

    </script>
@endsection
@endsection
