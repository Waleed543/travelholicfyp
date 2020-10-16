@extends('admin.layouts.dashboardAdmin')
@section('title','Hotel Edit')
@section('hotel','current')
@section('headerName', 'Edit Hotel')
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
                                <strong>Update Hotel</strong>
                            </div>
                            <div class="card-body card-block">

                                <form  id="update" method="post" action="{{route('hotel.update',$hotel->slug)}}" enctype="multipart/form-data" class="form-horizontal">
                                    {{ csrf_field() }}
                                    @method('PUT')

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="name" class=" form-control-label"><h3>Name</h3></label>
                                            <input type="text" id="name" name="name" value="{{old('name') ?? $hotel->name}}" class="form-control @error('name') is-invalid @enderror" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="city" class=" form-control-label"><h3>City</h3></label>
                                        <select name="city" id="city" Value="{{old('city') ?? $hotel->city}}" class="form-control @error('city') is-invalid @enderror" required>
                                            <option value="">Please select</option>
                                            @if(count($cities)>0)
                                                @foreach($cities as $city)
                                                    @if(old('city') == $city->id or $hotel->city == $city->id)
                                                        <option selected value="{{$city->id}}">{{$city->name}}</option>
                                                    @else
                                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                        @enderror
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-md-12">
                                            <label for="inputContent" class=" form-control-label"><h3>Description</h3></label>
                                            <textarea  rows="7" name="description"class="form-control @error('description') is-invalid @enderror">{{old('description') ?? $hotel->description}}</textarea>
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
@section('js')
    <script src="{{asset('js/tag/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/tag/typeahead.bundle.js')}}" type="text/javascript"></script>
    <script>
        var tags = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '/tag/name',
                filter: function(list) {
                    return $.map(list, function(tag) {
                        return { name: tag }; });
                },
                cache:false,
                ttl:60000
            }
        });
        tags.initialize();
        $('#blood').tagsinput({
            typeaheadjs: {
                name: 'tags',
                displayKey: 'name',
                valueKey: 'name',
                source: tags.ttAdapter()
            }
        });
        $(document).ready(function(){
            $(".tt-input").keypress(function(e){
                if(e.which == 13) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
@endsection
