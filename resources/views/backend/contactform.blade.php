@extends('layouts.backend')

@section('title', 'Contact Form')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="content">
    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <div class="container">
            <div class="row">
                <form role="form" action="#" method="post">
                    <!-- START PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                contact form
                            </div>
                        </div>
                        <div class="panel-body">
                            <h5 id="successResponse"></h5>
                            <div class="form-group date" id="datepicker-component">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" maxlength="70">
                            </div>
                            <div class="form-group date" id="datepicker-component2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" maxlength="70">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" name="message" id="message" rows="10" maxlength="255"></textarea>
                            </div>
                            {!! csrf_field() !!}
                            <button class="btn btn-primary btn-cons" id="sendContactDetails">Send</button>
                        </div>
                    </div>
                    <!-- END PANEL -->
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('button').click(function(e){
        e.preventDefault();
        var name    = $("#name").val();
        var email   = $("#email").val();
        var phone   = $("#phone").val();
        var message = $("#message").val();
        $.post('{{route('contact.store')}}', {name: name, email: email, phone: phone, message: message},
                function(response){
                    $('#successResponse').html(response.response);
                });
    });
</script>
@endsection

