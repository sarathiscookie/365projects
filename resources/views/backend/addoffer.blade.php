@extends('layouts.backend')
@section('title', 'Add Offer')
@section('styles')
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" href="/assets/css/style.css">
@endsection
@section('content')
    <div class="content">
        @include('backend.partials.facilitynav')
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid col-sm-10">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
                        <!-- START PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create offer
                    </div>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form" action="{{ url('/facility/offer/'.$facility->id.'/save') }}" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Subtitle" value="{{ old('subtitle') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-default">
                            <label for="alias">Alias</label>
                            <input type="text" class="form-control" name="alias" id="alias" placeholder="Alias" value="{{ old('alias') }}">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="10" style="height: 175px">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="header">Header</label>
                                    <textarea class="form-control" name="header" id="header" rows="10" style="height: 175px">{{ old('header') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="footer">Footer</label>
                                    <textarea class="form-control" name="footer" id="footer" rows="10" style="height: 175px">{{ old('footer') }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="freetext1">Freetext1</label>
                                    <textarea class="form-control" name="freetext1" id="freetext1" rows="10" style="height: 175px">{{ old('freetext1') }}</textarea>
                                </div>
                            </div>
                        </div>
                    <div class="form-group form-group-default">
                        <label for="freetext2">Freetext2</label>
                        <textarea class="form-control" name="freetext2" id="freetext2" rows="10" style="height: 175px">{{ old('freetext2') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" name="type" id="type" placeholder="Type" value="{{ old('type') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="typedate">Type Date</label>
                                <input type="text" class="form-control" name="typedate" id="typedate" placeholder="Type Date" value="{{ old('typedate') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="pseudoprice">Pseudo Price</label>
                                <input type="text" class="form-control" name="pseudoprice" id="pseudoprice" placeholder="Pseudo Price" value="{{ old('pseudoprice') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="discount">Discount</label>
                                <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount" value="{{ old('discount') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="offline">Offline</option>
                                    <option value="online">Online</option>
                                    <option value="hidden">Hidden</option>
                                    <option value="deleted">Deleted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default input-prepend input-group">
                                <label for="daterangepicker">Published date - Range</label>
                                <input type="text" style="width: 100%" name="publishrange" id="daterangepicker" class="form-control" value="{{ old('publishrange') }}" placeholder="Published to Unpublished date" readonly />
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- For form fields begin -->
                        @if ($groupTitle)
                            <h5>{{$groupTitle}}</h5>
                            @if ($groupID)
                                <input type="hidden" value="{{ $groupID }}" name="groupID">
                            @endif
                            @foreach ($formFields as $formField)
                                @if ($formField->type == 'input')
                                    <div class="form-group form-group-default">
                                        <label for="{{ $formField->title }}">{{ $formField->title }}</label>
                                        <input type="text" class="form-control" name="dynField_{{$formField->id}}" id="fieldInput" placeholder="{{ $formField->placeholder }}" value="{{ old('dynField_'.$formField->id) }}">
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'checkbox')
                                    <div class="checkbox check-success">
                                        <input type="checkbox" name="dynField_{{$formField->id}}" id="fieldCheckbox{{$formField->id}}">
                                        <label for="fieldCheckbox{{$formField->id}}">{{ $formField->title }}</label>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'textarea')
                                    <div class="form-group form-group-default">
                                        <label for="{{ $formField->title }}">{{ $formField->title }}</label>
                                        <textarea class="form-control" name="dynField_{{$formField->id}}" rows="10" id="fieldTextarea" style="height: 175px">{{ old('dynField_'.$formField->id) }}</textarea>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'select')
                                    <div class="form-group form-group-default">
                                        <label for="Lbl{{ $formField->id }}">{{ $formField->title }}</label>
                                        <select name="dynField_{{$formField->id}}" id="Lbl{{ $formField->id }}" class="form-control">
                                            @forelse(explode("|",$formField->options) as $options)
                                                <option value="{{ explode(":",$options)[0] }}">{{ explode(":",$options)[1] }}</option>
                                            @empty
                                                <option value="">No options available</option>
                                            @endforelse
                                        </select>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'radio')
                                    <div class="radio radio-success">
                                        <span class="bold text-uppercase small">{{ $formField->title }}</span>
                                        @foreach(explode("|",$formField->options) as $options)
                                            <input type="radio" name="dynField_{{$formField->id}}" value="{{ explode(":",$options)[0] }}" id="dynField_{{explode(":",$options)[1]}}">
                                            <label for="dynField_{{explode(":",$options)[1]}}">{{ explode(":",$options)[1] }}</label>
                                        @endforeach
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    <!-- For form fields end -->
                    {!! csrf_field() !!}
                    <div class="p-t-10"><button class="btn btn-primary btn-cons">Create Offer</button></div>
                    </form>
                </div>
            </div>
                        <!-- END PANEL -->

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
@endsection

@section('scripts')
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
       $(document).ready(function() {
           $('#daterangepicker').daterangepicker({
               timePicker:true,
               timePickerIncrement:30,
               timePicker24Hour: true,
               format:'DD-MM-YYYY h:mm A',
               separator: ' To ',
               drops: 'up'
           });
       });

       $('#navFclOfr').addClass('active');
    </script>
@endsection

