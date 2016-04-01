@extends('layouts.backend')

@section('title', 'Facility Images')

@section('styles')
    <link href="/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/includes/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="/includes/css/bootstrap-image-gallery.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
@endsection

@section('content')
    <div class="content">
        @include('backend.partials.facilitynav')
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid col-md-10 bg-white">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="panel panel-transparent">
                <div class="panel-heading">
                    <div class="panel-title">{{$facility->title}} - Facility Images
                    </div>
                </div>
                <div class="panel-body no-padding">
                    <div class="panel panel-transparent">
                        <ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white" id="tab-3">
                            <li class="active">
                                <a aria-expanded="true" data-toggle="tab" href="#tabGallery">Gallery</a>
                            </li>
                            <li class="">
                                <a aria-expanded="false" data-toggle="tab" href="#tabDropzone">Upload</a>
                            </li>
                        </ul>
                        <div class="tab-content bg-white">
                            <div class="tab-pane active" id="tabGallery">
                                <div id="links">
                                    @foreach($pictures as $file)
                                        @if($file!='.' && $file!='..')
                                            <div class="inline trash-img">
                                            <a href="{{ '/facility-image/'.$facility->id.'/gallery/'.$file }}" title="{{$file}}" data-gallery>
                                                <img src="{{ '/includes/phpThumb/phpThumb.php?w=250&src=/'.$facility->id.'/gallery/'.$file }}" alt="{{$file}}">
                                            </a>
                                            <button data-popout="true" data-singleton="true" title="Confirm delete image?" data-original-title="" data-toggle="confirmation-singleton" data-placement="bottom" class="btn btn-danger btn-xs btn-mini bold fs-14 del-image" id="galimg-{{$facility->id}}_{{ explode(".",$file)[0]}}">&times;</button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="tabDropzone">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Upload Images to this Facility
                                        </div>
                                    </div>
                                    <div class="panel-body no-scroll no-padding">
                                        <form action="{{url('/facilities/upload/'.$facility->id)}}" class="dropzone no-margin dz-clickable" id="dropzoneFrm">
                                            {!! csrf_field() !!}
                                            <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                                        </form>
                                    </div>
                                </div>
                                <a href="{{url('/facilities/images/'.$facility->id)}}" role="button" class="btn btn-success btn-cons">Finish</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery" data-use-bootstrap-modal="false">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> {{--gallery end--}}
@endsection

@section('scripts')
    <script type="text/javascript" src="/assets/plugins/dropzone/dropzone.min.js"></script>
    <script src="/includes/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/includes/js/bootstrap-image-gallery.min.js"></script>
    <script src="/includes/js/bootstrap-confirmation.min.js"></script>

    <script>
        //Jquery Confirm box
        $('[data-toggle="confirmation-singleton"]').confirmation({btnOkClass:'btn-xs btn-success'});
        //Tabs - on shown event actions
        $('a[href="#tabDropzone"]').on('shown.bs.tab', function (e) {
            $(".dz-preview").remove();
            $("#dropzoneFrm").removeClass('dz-started');
            $("#dropzoneFrm")[0].reset();
        });

        //delete facility image -single

        $('[data-toggle="confirmation-singleton"]').on('confirmed.bs.confirmation', function () {
            $(".trash-img").on('click', '.del-image', function (e) {
                var element_id = $(this).attr('id');
                var image_id = $(this).attr('id').split("-");
                $.post("/facilities/image/delete", {item: image_id[1]}, function (data) {
                    if ($('#alert_div').length) {
                        $('#alert_div').remove();
                    }
                    if (data.mes == "done") {
                        $('#' + element_id).closest(".trash-img").remove();
                    }
                    else {
                        htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<span id="alert_msg">' + data.mes + '</span>' +
                                '</div>';
                        $(htmlstr).insertAfter($('#links'));
                        $("#alert_div").fadeTo(5000, 500).slideUp(500, function () {
                            $("#alert_div").alert('close');
                        });
                    }
                }, "json");
            });
        });

    </script>
    <script>
        var token = "<?=csrf_token();?>";
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-Token' : token }
        });

        $('#navEdtFcl').addClass('active');
    </script>
@endsection

