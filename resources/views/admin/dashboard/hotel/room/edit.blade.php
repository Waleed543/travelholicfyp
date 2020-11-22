@extends('admin.layouts.dashboardAdmin')
@section('title','Edit Room Type')
@section('hotel','current')
@section('headerName', 'Edit Room')
@section('content')

@section('css')
    <link rel="stylesheet" type href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" type href="/css/tag/app.css">
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
        }
        .label-info {
            background-color: #5bc0de;
        }
        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: inline-block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }

    </style>
@endsection


<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row pt-md-5 mt-md-3 mb-5">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                <strong>Create Hotel</strong>
                            </div>
                            <div class="card-body card-block">
                                <form  id="create" method="post" action="{{route('room.update',[$slug,$room_slug])}}" enctype="multipart/form-data" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="name" class=" form-control-label"><h3>Name</h3></label>
                                            <input type="text" id="name" name="name" value="{{old('name')?? $room->name}}" class="form-control @error('name') is-invalid @enderror" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="facilities" class=" form-control-label"><h3>Select Facilities</h3></label>
                                        <select data-placeholder="Begin typing a name to filter..." multiple class="chosen-select form-control" name="facilities[]">
                                            <option value=""></option>
                                            @if(count($facilities)>0)
                                                @foreach($facilities as $facility)
                                                    <option>{{$facility->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('facilities')
                                        <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                        @enderror
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="total" class=" form-control-label"><h3>Total Rooms</h3></label>
                                            <input type="number" id="total" name="total" value="{{old('total')?? $room->total}}" class="form-control @error('total') is-invalid @enderror" required>
                                            @error('total')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="beds" class=" form-control-label"><h3>No. of Beds</h3></label>
                                            <input type="number" id="beds" name="beds" value="{{old('beds')?? $room->beds}}" class="form-control @error('beds') is-invalid @enderror" required>
                                            @error('beds')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="capacity" class=" form-control-label"><h3>Capacity(Person allowed in one room)</h3></label>
                                            <input type="number" id="capacity" name="capacity" value="{{old('capacity')?? $room->capacity}}" class="form-control @error('beds') is-invalid @enderror" required>
                                            @error('capacity')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="price" class=" form-control-label"><h3>Price Per Room</h3></label>
                                            <input type="number" id="price" name="price" value="{{old('price')?? $room->price}}" class="form-control @error('price') is-invalid @enderror" required>
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-md-12">
                                            <label for="inputContent" class=" form-control-label"><h3>Description</h3></label>
                                            <textarea  rows="7" name="description"class="form-control @error('description') is-invalid @enderror">{{old('name')?? $room->description}}</textarea>
                                            @error('description')
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
                                            <input type="file" id="file-input" name="image" class="form-control-file">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" onkeypress="event.preventDefault();" value="submit" form="create">
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

@section('js')
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })
    </script>
@endsection
@endsection
