@extends('admin.layouts.dashboardAdmin')
@section('title','Tour Profile')
@section('tour','current')
@section('headerName', 'Tour Profile')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Update Profile</strong>
                                </div>
                                <div class="card-body card-block">
                                    <form  id="update" method="post" action="{{route('tour.profile.store',$tour->slug)}}" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="row form-group">
                                            @if(count($tour_days)>0)
                                                @foreach($tour_days as $day)
                                                    <div class="col-lg-12">
                                                        <label for="day-{{$day->number}}" class=" form-control-label"><h3>Day {{$day->number}}</h3></label>
                                                        <textarea class="form-control" name="day-{{$day->number}}" rows="3">{{$day->description}}</textarea>
                                                        @error("day-{{$day->number}}")
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            @else
                                                @for ($i = 1; $i <= $tour->days; $i++)
                                                    <div class="col-lg-12">
                                                        <label for="day-{{$i}}" class=" form-control-label"><h3>Day {{$i}}</h3></label>
                                                        <textarea class="form-control" name="day-{{$i}}" rows="3"></textarea>
                                                        @error("day-{{$i}}")
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                @endfor
                                            @endif
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
{{--    <script>--}}
{{--        function add_day(parent, child) {//4,5--}}

{{--            var temp = document.getElementById("child-"+child).innerHTML;//7--}}
{{--            if(temp)--}}
{{--            {--}}
{{--                var from = child+1;--}}
{{--                var to = parseInt(temp);--}}
{{--                if(to-from == 0)--}}
{{--                {--}}
{{--                    const div = document.createElement('div');--}}
{{--                    div.setAttribute('class',"col-lg-12");--}}
{{--                    div.innerHTML =`--}}
{{--                                <span id="day-${from}">--}}
{{--                                    <div class="row">--}}
{{--                                    <div class="col-lg-3">--}}
{{--                                    <label for="day-${from}" class=" form-control-label"><h3>Day ${from}</h3></label>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-9">--}}
{{--                                    <button hidden type="button" id="remove-button-${from}" class="btn btn-primary"></button>--}}
{{--                                <button type="button" id="add-button-${from}" onclick="add_day(${from},${to+1})" class="btn btn-primary">Add Day ${to+1}</button>--}}
{{--                                </div>--}}
{{--                                </div>--}}
{{--                                <textarea class="form-control" name="day-${from}" id="day-description-${from}" rows="5"></textarea>--}}
{{--                                    <span hidden id="child-${from}"></span>--}}
{{--                                    </span>--}}
{{--                                    <span hidden id="add-child-${from}"></span>--}}
{{--                                    `;--}}


{{--                    $("#add-child-"+parent).replaceWith(div);--}}

{{--                }else{--}}
{{--                    const div = document.createElement('div');--}}
{{--                    div.setAttribute('class',"col-lg-12");--}}
{{--                    div.innerHTML =`--}}
{{--                                <span id="day-${from}">--}}
{{--                                    <div class="row">--}}
{{--                                    <div class="col-lg-3">--}}
{{--                                    <label for="day-${from}" class=" form-control-label"><h3>Day ${from}-${to}</h3></label>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-9">--}}
{{--                                    <button type="button" id="remove-button-${from}" class="btn btn-primary">Remove Day ${to}</button>--}}
{{--                                <button type="button" id="add-button-${from}" onclick="add_day(${from},${to+1})" class="btn btn-primary">Add Day ${to+1}</button>--}}
{{--                                </div>--}}
{{--                                </div>--}}
{{--                                <textarea class="form-control" name="day-${from}" id="day-description-${from}" rows="5"></textarea>--}}
{{--                                    <span hidden id="child-${from}">${to}</span>--}}
{{--                                    </span>--}}
{{--                                    <span hidden id="add-child-${from}"></span>--}}
{{--                                    `;--}}


{{--                    $("#add-child-"+parent).replaceWith(div);--}}
{{--                }--}}

{{--            }--}}
{{--            document.getElementById("day-"+child).remove();--}}
{{--            document.getElementById("add-button-"+parent).innerHTML = "Add Day "+(child+1);--}}
{{--            document.getElementById("add-button-"+parent).removeAttribute("onclick");--}}
{{--            document.getElementById("add-button-"+parent).setAttribute("onclick", `add_day(${parent},${child+1})`);--}}
{{--            document.getElementById("child-"+parent).innerHTML = child;--}}

{{--            document.getElementById("remove-button-"+parent).removeAttribute("hidden");--}}
{{--            document.getElementById("remove-button-"+parent).innerHTML = "Remove Day "+(child);--}}
{{--            document.getElementById("remove-button-"+parent).removeAttribute("onclick");--}}
{{--            document.getElementById("remove-button-"+parent).setAttribute("onclick", `add_day(${parent},${child+1})`);--}}


{{--        }--}}
{{--    </script>--}}
@endsection
