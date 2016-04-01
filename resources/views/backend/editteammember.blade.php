@extends('layouts.backend')

@section('title', 'Edit Facility')

@section('styles')
    <link rel="stylesheet" href="/includes/css/html5imageupload.css">
    <link rel="stylesheet" href="/assets/css/style.css">
@endsection

@section('content')
    <div class="content">
        @include('backend.partials.facilitynav')
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid col-md-10">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{$facility->title}} - Edit Team Member
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
                    <div class="row">
                        <div class="col-md-6">
                    <form method="post" class="" role="form" action="{{url('/facility/team/update')}}">
                        {!! csrf_field() !!}
                        <div class="form-group form-group-default required ">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$member->name}}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" name="position" id="position" value="{{$member->position}}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{$member->phone}}">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" value="{{$member->email}}">
                        </div>
                        <input type="hidden" name="team_id" value="{{$member->id}}">
                        <button class="btn btn-primary" type="submit">Update Member</button>
                        <a href="{{url('/facility/team/'.$facility->id)}}" role="button" class="btn btn-default">Cancel</a>
                    </form>
                        </div>
                        <div class="col-md-6">
                            <section id="profile">
                                <div id="profile_image" class="dropzone smalltext" data-removeurl="{{url('/facility/teamImage/delete/'.$member->id)}}"  @if($member_image==$member->id) data-image="{{url('/facility/team/image/'.$member->id)}}" @endif data-button-edit="false" data-width="300" data-height="300" data-originalsize="false" data-url="{{url('/facility/team/upload/'.$member->id)}}" style="border-radius: 150px;">
                                    <input type="file" name="thumb" style="-webkit-border-radius: 150px;-moz-border-radius: 150px;border-radius: 150px;"/>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
@endsection
@section('scripts')
    <script src="/includes/js/html5imageupload.min.js"></script>
    <script>
        var token = "<?=csrf_token();?>";
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-Token' : token }
        });
    </script>
    <script>
        /* NEW DROPZONE PROFILE IMG */
        $('.dropzone').html5imageupload();
        $('#navFclMem').addClass('active');
    </script>
@endsection