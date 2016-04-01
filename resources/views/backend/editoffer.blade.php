@extends('layouts.backend')
@section('title', 'Edit Offer')
@section('styles')
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .daterangepicker{
            z-index: 1150 !important;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        @include('backend.partials.facilitynav')
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid col-sm-10">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

            <!-- START PANEL -->
            <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Edit offer
                    </div>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form" action="{{url('/facility/offer/update/'.$offerDetails->id)}}" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{$offerDetails->title}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{$offerDetails->subtitle}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-default">
                        <label for="alias">Alias</label>
                        <input type="text" class="form-control" name="alias" id="alias" value="{{$offerDetails->alias}}">
                    </div>
                    <div class="form-group form-group-default">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="10" style="height: 175px">{{$offerDetails->description}}</textarea>
                    </div>
                    <div class="form-group form-group-default">
                        <label for="header">Header</label>
                        <textarea class="form-control" name="header" id="header" rows="10" style="height: 175px">{{$offerDetails->header}}</textarea>
                    </div>
                    <div class="form-group form-group-default">
                        <label for="footer">Footer</label>
                        <textarea class="form-control" name="footer" id="footer" rows="10" style="height: 175px">{{$offerDetails->footer}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="freetext1">Freetext1</label>
                        <textarea class="form-control" name="freetext1" id="freetext1" rows="10" style="height: 175px">{{$offerDetails->freetext1}}</textarea>
                    </div>
                    <div class="form-group form-group-default">
                        <label for="freetext2">Freetext2</label>
                        <textarea class="form-control" name="freetext2" id="freetext2" rows="10" style="height: 175px">{{$offerDetails->freetext2}}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" name="type" id="type" value="{{$offerDetails->type}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="typedate">Type Date</label>
                                <input type="text" class="form-control" name="typedate" id="typedate" value="{{$offerDetails->type_date}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" value="{{$offerDetails->price}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="pseudoprice">Pseudo Price</label>
                                <input type="text" class="form-control" name="pseudoprice" id="pseudoprice" value="{{$offerDetails->pseudo_price}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="discount">Discount</label>
                                <input type="text" class="form-control" name="discount" id="discount" value="{{$offerDetails->discount}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="offline" @if($offerDetails->status == 'offline') {{ 'selected="selected"' }} @endif>Offline</option>
                                    <option value="online"  @if($offerDetails->status == 'online') {{ 'selected="selected"' }} @endif>Online</option>
                                    <option value="hidden"  @if($offerDetails->status == 'hidden') {{ 'selected="selected"' }} @endif>Hidden</option>
                                    <option value="deleted" @if($offerDetails->status == 'deleted') {{ 'selected="selected"' }} @endif>Deleted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-default input-prepend input-group">
                        <label for="daterangepicker">Published date - Range</label>
                        <input type="text" style="width: 100%" name="publishrange" id="daterangepicker" class="form-control" value="{{$date_range}}" placeholder="Published to Unpublished date" readonly />
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
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
                                        <input type="text" class="form-control" name="dynField_{{$formField->id}}" id="fieldInput" value="{{ $formField->value }}">
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                        <input type="hidden" value="{{ $formField->formvalueid }}" name="formValueID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'checkbox')
                                    <div class="checkbox check-success">
                                        <input type="checkbox" name="dynField_{{$formField->id}}" id="fieldCheckbox{{$formField->id}}" @if ($formField->value!=null) value="{{ $formField->value }}" @endif @if ($formField->value) {{ "checked" }} @endif>
                                        <label for="fieldCheckbox{{$formField->id}}">{{ $formField->title }}</label>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                        <input type="hidden" value="{{ $formField->formvalueid }}" name="formValueID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'textarea')
                                    <div class="form-group form-group-default">
                                        <label for="{{ $formField->title }}">{{ $formField->title }}</label>
                                        <textarea class="form-control" name="dynField_{{$formField->id}}" rows="10" id="fieldTextarea" style="height: 175px">{{ $formField->value }}</textarea>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                        <input type="hidden" value="{{ $formField->formvalueid }}" name="formValueID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'select')
                                    <div class="form-group form-group-default">
                                        <label for="Lbl{{ $formField->id }}">{{ $formField->title }}</label>
                                        <select name="dynField_{{$formField->id}}" id="Lbl{{ $formField->id }}" class="form-control">
                                            @forelse(explode("|",$formField->options) as $options)
                                                <option value="{{ explode(":",$options)[0] }}" @if ($formField->value==explode(":",$options)[0]) {{ "selected" }} @endif>{{ explode(":",$options)[1] }}</option>
                                            @empty
                                                <option value="">No options available</option>
                                            @endforelse
                                        </select>
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                        <input type="hidden" value="{{ $formField->formvalueid }}" name="formValueID[]">
                                    </div>
                                @endif
                                @if ($formField->type == 'radio')
                                    <div class="radio radio-success">
                                        <span class="bold text-uppercase small">{{ $formField->title }}</span>
                                        @foreach(explode("|",$formField->options) as $options)
                                            <input type="radio" name="dynField_{{$formField->id}}" value="{{ explode(":",$options)[0] }}" @if ($formField->value==explode(":",$options)[0]) {{ "checked" }} @endif id="dynField_{{explode(":",$options)[1]}}">
                                            <label for="dynField_{{explode(":",$options)[1]}}">{{ explode(":",$options)[1] }}</label>
                                        @endforeach
                                        <input type="hidden" value="{{ $formField->id }}" name="fieldID[]">
                                        <input type="hidden" value="{{ $formField->formvalueid }}" name="formValueID[]">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    <!-- For form fields end -->

                    {!! csrf_field() !!}
                    <button class="btn btn-primary btn-cons">Update Offer</button>
                    <button type="button" class="btn btn-primary btn-cons pull-right" data-toggle="modal" data-target="#modalOfferDate">Add Date</button>
                    </form>
                </div>
            </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                           Edit Offer Dates
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(count($offerDates)>0)
                            <div class="panel panel-group panel-transparent" data-toggle="collapse" id="accordion">
                            @foreach($offerDates as $date)
                                <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-parent="#accordion" data-toggle=
                                        "collapse" href="#collapse{{$date->id}}">{{ date('d.m.Y',strtotime($date->date_begin)).' - '.date('d.m.Y',strtotime($date->date_end)) }}</a>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapse{{$date->id}}">
                                    <div class="panel-body">
                                        <form role="form" id="DateEditFrm{{$date->id}}" method="post">
                                            <div class="form-group form-group-default input-prepend input-group">
                                                <label for="offerdate{{$date->id}}">Date Begin - End</label>
                                                <input type="text" style="width: 100%" name="offerdate" id="offerdate{{$date->id}}" class="form-control rangepicker" value="{{ date('d-m-Y',strtotime($date->date_begin)).' To '.date('d-m-Y',strtotime($date->date_end)) }}" placeholder="Date Begin - Date End" readonly />
                                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label for="nights{{$date->id}}">Nights</label>
                                                <input type="number" class="form-control" name="nights" id="nights{{$date->id}}" value="{{$date->nights}}" min="1" max="15">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label for="arrival{{$date->id}}">Arrival</label>
                                                <input type="number" class="form-control" name="arrival" id="arrival{{$date->id}}" value="{{$date->arrival}}" min="1" max="7">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label for="type{{$date->id}}">Type</label>
                                                <input type="text" class="form-control" name="type" id="type{{$date->id}}" value="{{$date->type}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label for="status{{$date->id}}">Status</label>
                                                <select class="form-control" name="status" id="status{{$date->id}}">
                                                    <option value="online" @if($date->status=='online') selected="selected" @endif>Online</option>
                                                    <option value="offline" @if($date->status=='offline') selected="selected" @endif>Offline</option>
                                                    <option value="soldout" @if($date->status=='soldout') selected="selected" @endif>Soldout</option>
                                                    <option value="lastchance" @if($date->status=='lastchance') selected="selected" @endif>Lastchance</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="date_id" value="{{$date->id}}">
                                            {!! csrf_field() !!}
                                            <button id="updateDatebtn_{{$date->id}}" type="button" class="btn btn-primary btn-block updateDateBtn">Update Date</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        @else
                            <div><small>No offer dates found!</small></div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- END PANEL -->

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- Add offer date Modal -->
    <div class="modal fade slide-up disable-scroll" id="modalOfferDate" tabindex="-1" role="dialog" aria-labelledby="modalOfferDateLabel" aria-hidden="false">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close fs-14"></i>
                        </button>
                        <h5>Add Offer Date</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="offerDateFrm" method="post">
                            <div class="form-group form-group-default input-prepend input-group">
                                <label for="offerdate">Date Begin - End</label>
                                <input type="text" style="width: 100%" name="offerdate" id="offerdate" class="form-control rangepicker" value="" placeholder="Date Begin - Date End" readonly />
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                            </div>
                            <div class="form-group form-group-default">
                                <label for="nights">Nights</label>
                                <input type="number" class="form-control" name="nights" id="nights" min="1" max="15">
                            </div>
                            <div class="form-group form-group-default">
                                <label for="arrival">Arrival</label>
                                <input type="number" class="form-control" name="arrival" id="arrival" min="1" max="7">
                            </div>
                            <div class="form-group form-group-default">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" name="type" id="type">
                            </div>
                            <div class="form-group form-group-default">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="soldout">Soldout</option>
                                    <option value="lastchance">Lastchance</option>
                                </select>
                            </div>
                            <input type="hidden" name="offer_id" value="{{$offerDetails->id}}">
                            {!! csrf_field() !!}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="addDatebtn" type="button" class="btn btn-primary">Create Date</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
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
            $(document).ready(function() {
                $('.rangepicker').daterangepicker({
                    format:'DD-MM-YYYY',
                    separator: ' To ',
                    drops: 'up'
                });
            });

            //add - Offerdate
            $('#addDatebtn').click( function() {
                if ($('#alert_div').length) {
                    $('#alert_div').remove();
                }
                if ($('#offerdate').val() == '') {
                    var htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            '<span id="alert_msg"><strong>Error: </strong>Date range is required!</span>' +
                            '</div>';
                    $(htmlstr).insertBefore('#offerDateFrm');
                    return false;
                }
                var params = $('#offerDateFrm').serialize();
                $.post("{{ url('/offer/offerdate/save') }}", params, function (data) {
                    if (data.response > 0) {
                        $('#offerDateFrm')[0].reset();
                        var htmlstr = '<div class="alert alert-success" id="alert_div" role="alert">' +
                                '<span id="alert_msg">Added successfully&hellip; reloading&hellip;</span>' +
                                '</div>';
                        $(htmlstr).insertBefore('#offerDateFrm');
                        $("#alert_div").fadeTo(2500, 500).slideUp(500, function () {
                            $("#alert_div").alert('close');
                            $("#modalOfferDate").modal('hide');
                            location.reload();
                        });
                    }
                    else {
                        var htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                                '<span id="alert_msg">Error, Date not added</span>' +
                                '</div>';
                        $(htmlstr).insertBefore('#offerDateFrm');
                        $("#alert_div").fadeTo(3000, 500).slideUp(500, function () {
                            $("#alert_div").alert('close');
                        });
                    }
                }, "json");
            });

            //Update - Offerdate
            $('.updateDateBtn').click( function() {
                var id = $(this).attr('id').split("_")[1];
                if ($('#alert_div').length) {
                    $('#alert_div').remove();
                }
                if ($('#offerdate' + id).val() == '') {
                    var htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            '<span id="alert_msg"><strong>Error: </strong>Date range is required!</span>' +
                            '</div>';
                    $(htmlstr).insertBefore('#DateEditFrm' + id);
                    return false;
                }
                var params = $('#DateEditFrm' + id).serialize();
                $.post("{{ url('/offer/offerdate/update') }}", params, function (data) {
                    if (data.response > 0) {
                        var htmlstr = '<div class="alert alert-success" id="alert_div" role="alert">' +
                                '<span id="alert_msg">Updated successfully&hellip; reloading&hellip;</span>' +
                                '</div>';
                        $(htmlstr).insertBefore('#DateEditFrm' + id);
                        $("#alert_div").fadeTo(2500, 500).slideUp(500, function () {
                            $("#alert_div").alert('close');
                            location.reload();
                        });
                    }
                    else {
                        var htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                                '<span id="alert_msg">Error, not updated</span>' +
                                '</div>';
                        $(htmlstr).insertBefore('#DateEditFrm' + id);
                        $("#alert_div").fadeTo(3000, 500).slideUp(500, function () {
                            $("#alert_div").alert('close');
                        });
                    }
                }, "json");
            });

            //on closing modal clear form/alert messages
            $('#modalOfferDate').on('hidden.bs.modal', function (e) {
                $('#offerDateFrm')[0].reset();
                if($('#alert_div').length){
                    $('#alert_div').remove();
                }
            });

            $('#navFclOfr').addClass('active');
        </script>
@endsection

