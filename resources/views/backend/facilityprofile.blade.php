@extends('layouts.backend')

@section('title', 'Facility Profile - '.$facility->title)

@section('styles')
    <link rel="stylesheet" href="/includes/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="/includes/css/bootstrap-image-gallery.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
@endsection

@inject('viewObj', 'App\Http\Controllers\Backend\FacilityprofileController')

@section('content')
    <div class="content">
        @include('backend.partials.facilitynav')
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid col-md-10">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="panel">
                <h1>Facility profile - {{$facility->title}}</h1>
                <ul class="nav nav-tabs nav-tabs-simple hidden-xs" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active"><a href="#tabMain" data-toggle="tab" role="tab" aria-expanded="true">Facility</a>
                    </li>
                    <li class=""><a href="#tabMembers" data-toggle="tab" role="tab" aria-expanded="false">Team</a>
                    </li>
                    <li class=""><a href="#tabOffers" data-toggle="tab" role="tab" aria-expanded="false">Offers</a>
                    </li>
                </ul><div class="panel-group visible-xs" id="vpuMQ-accordion"></div>
                <div class="tab-content hidden-xs">
                    <div class="tab-pane active" id="tabMain">
                        <div class="row column-seperation">
                            <div class="col-md-7">
                                <h3>Facility Details</h3>
                                <div class="well">
                                    <label class="bold">Title</label>
                                    <p>{{$facility->title}}</p>
                                    <label class="bold">Content</label>
                                    <p>{{$facility->content}}</p>
                                    <label class="bold">Services</label>
                                    <p>{{$facility->services}}</p>
                                    <label class="bold">Terms</label>
                                    <p>{{$facility->terms}}</p>
                                </div>
                                {!! $form_values !!}
                            </div>
                            <div class="col-md-5">
                                <h3>Gallery</h3>
                                <div id="links">
                                    @foreach($pictures as $file)
                                        @if($file!='.' && $file!='..')
                                            <div class="inline trash-img">
                                                <a href="{{ '/facility-image/'.$facility->id.'/gallery/'.$file }}" title="{{$file}}" data-gallery>
                                                    <img src="{{ '/includes/phpThumb/phpThumb.php?w=250&src=/'.$facility->id.'/gallery/'.$file }}" alt="{{$file}}">
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabMembers">
                        <div class="row">
                            <div class="col-md-12">
                            <h3>Members</h3>
                                @foreach($members as $member)
                                    <div class="media col-md-4">
                                        <div class="media-left">
                                            <section>
                                                @if($viewObj->getMemberImage($member->facility_id,$member->id) !='')
                                                    <img class="media-object img-circle" src="{{ '/includes/phpThumb/phpThumb.php?w=100&src=/'.$facility->id.'/team/'.$member->id.'.jpg' }}" alt="{{$member->id}}">
                                                @else
                                                    <div class="thumb-circle"><img class="media-object" src="{{ '/includes/phpThumb/phpThumb.php?w=100&src='.str_replace('\\', '/', public_path()).'/profile.png' }}" alt="{{$member->id}}"></div>
                                                @endif
                                            </section>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{$member->name}}</h4>
                                            <p>{{$member->position}} @if($member->phone!='') | {{$member->phone}} @endif</p>
                                            @if($member->email!='')<p><a href="mailto:{{$member->email}}">Email</a></p>@endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabOffers">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Offers</h3>
                                {!! $offers !!}
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
    <script src="/includes/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/includes/js/bootstrap-image-gallery.min.js"></script>
    <script>
        $('#navFclOvw').addClass('active');
    </script>
@endsection