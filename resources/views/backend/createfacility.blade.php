@extends('layouts.backend')

@section('title', 'Create Facility')

@section('content')
    <div class="content">
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create Facility
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
                    <form method="post" class="" role="form" action="{{url('/facilities/save')}}">
                        {!! csrf_field() !!}
                        <div class="form-group form-group-default required ">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="contents">Content</label>
                            <textarea class="form-control" name="contents" id="contents" rows="15" style="height: 175px">{{ old('contents') }}</textarea>
                        </div>
                        <div class="form-group form-group-default">
                            <label for="services">Services</label>
                            <textarea class="form-control" name="services" id="services" rows="15" style="height: 175px">{{ old('services') }}</textarea>
                        </div>
                        <div class="form-group form-group-default">
                            <label for="terms">Terms</label>
                            <textarea class="form-control" name="terms" id="terms" rows="15" style="height: 175px">{{ old('terms') }}</textarea>
                        </div>
                        <div class="form-group form-group-default">
                            <label for="terms">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="{{ old('country') }}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="terms">Street</label>
                            <input type="text" class="form-control" name="street" id="street" value="{{ old('street') }}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="terms">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="terms">Postal</label>
                            <input type="text" class="form-control" name="postal" id="postal" value="{{ old('postal') }}">
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
                                        <input type="checkbox" name="dynField_{{$formField->id}}" id="fieldCheckbox{{$formField->id}}" placeholder="{{ $formField->placeholder }}">
                                        <label for="fieldCheckbox{{$formField->id}}">{{ $formField->title }}</label>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'textarea')
                                    <div class="form-group form-group-default">
                                        <label for="{{ $formField->title }}">{{ $formField->title }}</label>
                                        <textarea class="form-control" name="dynField_{{$formField->id}}" rows="10" id="fieldTextarea" placeholder="{{ $formField->placeholder }}" style="height:150px;">{{ old('dynField_'.$formField->id) }}</textarea>
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
                        <button class="btn btn-primary" type="submit">Create Facility</button>
                    </form>
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
@endsection