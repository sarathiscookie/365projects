@extends('layouts.backend')

@section('title', 'Create Team Member')

@section('styles')
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
                        {{$facility->title}} - Create Team Member
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
                    <form method="post" class="" role="form" action="{{url('/facility/team/save')}}">
                        {!! csrf_field() !!}
                        <div class="form-group form-group-default required ">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" name="position" id="position">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="form-group form-group-default">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <input type="hidden" name="facility_id" value="{{$facility_id}}">
                        <button class="btn btn-primary" type="submit">Create Member</button>
                    </form>
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
@endsection
@section('scripts')
    <script>
        $('#navFclMem').addClass('active');
    </script>
@endsection