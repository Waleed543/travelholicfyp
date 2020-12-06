@extends('admin.layouts.dashboardAdmin')
@section('title','Vehicle Create')
@section('vehicle','current')
@section('headerName', 'Create Vehicle')
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
                                    <strong>Create Vehicle</strong>
                                </div>
                                <div class="card-body card-block">
                                    <form  id="create" method="post" action="{{route('vehicle.store')}}" enctype="multipart/form-data" class="form-horizontal">
                                        @csrf
                                        <div class="row form-group" id="bloodhound">
                                            <div class="col-lg-6">
                                                <label for="tags" class=" form-control-label"><h3>Tags</h3></label>
                                                <input type="text" data-role="tagsinput" id="blood" name="tags" value="{{old('tags')}}" class="form-control @error('tags') is-invalid @enderror">
                                                @error('tags')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="name" class=" form-control-label"><h3>Name</h3></label>
                                                <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="make" class=" form-control-label"><h3>Make (Company)</h3></label>
                                                <input type="text" id="make" name="make" value="{{old('make')}}" class="form-control @error('make') is-invalid @enderror" required>
                                                @error('make')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="model" class=" form-control-label"><h3>Model</h3></label>
                                                <input type="text" id="model" name="model" value="{{old('model')}}" class="form-control @error('model') is-invalid @enderror" required>
                                                @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="color" class=" form-control-label"><h3>Color</h3></label>
                                                <input type="text" id="color" name="color" value="{{old('color')}}" class="form-control @error('color') is-invalid @enderror" required>
                                                @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="year" class=" form-control-label"><h3>Year</h3></label>
                                                <input type="number" maxlength="4" id="year" name="year" value="{{old('year')}}" class="form-control @error('year') is-invalid @enderror" required>
                                                @error('year')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="condition" class=" form-control-label"><h3>Condition (Out of 10)</h3></label>
                                                <input type="number" maxlength="2" id="condition" name="condition" value="{{old('condition')}}" class="form-control @error('year') is-invalid @enderror" required>
                                                @error('condition')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="mileage" class=" form-control-label"><h3>MileAge</h3></label>
                                                <input type="number" id="mileage" name="mileage" value="{{old('mileage')}}" class="form-control @error('mileage') is-invalid @enderror" required>
                                                @error('mileage')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="vinumber" class=" form-control-label"><h3>VINumber</h3></label>
                                                <input type="number" id="vinumber" name="vinumber" value="{{old('vinumber')}}" class="form-control @error('vinumber') is-invalid @enderror" required>
                                                @error('vinumber')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="price" class=" form-control-label"><h3>Price</h3></label>
                                                <input type="number" id="price" name="price" value="{{old('price')}}" class="form-control @error('price') is-invalid @enderror" required>
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label for="city" class=" form-control-label"><h3>City</h3></label>
                                                <select name="city" id="city" class="form-control @error('city') is-invalid @enderror" required>
                                                    <option value="">Please select</option>
                                                    @if(count($cities)>0)
                                                        @foreach($cities as $city)
                                                            @if(old('city') == $city->id)
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
                                        </div>


                                        <div class="row form-group">
                                            <div class="col-12 col-md-12">
                                                <label for="inputContent" class=" form-control-label"><h3>Description</h3></label>
                                                <textarea  rows="7" name="description"class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
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
                                                <input type="file" id="file-input" name="image" class="form-control-file" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" onkeypress="event.preventDefault();" value="submit" form="create">
                                        Create
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
                    cache:true,
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
