@extends('layouts.backend')

@section('title', 'List Facility Team')

@section('styles')
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
              <div class="panel-title">{{$facility->title}} - Team
              </div>
              <div class="btn-group pull-right m-b-10">
                  <a href="{{url('/facility/team/create/'.$facility->id)}}" role="button" type="button" class="btn btn-primary">Add Member</a>
              </div>
              <div class="clearfix"></div>
          </div>
          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
          <div class="panel-body">
              <table class="table table-hover" id="tableFacility">
                  <thead>
                  <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td class="v-align-middle semi-bold">
                                <a href="{{url('/facility/team/edit/'.$member->id)}}">{{ $member->name }}</a>
                            </td>
                            <td>{{ $member->position }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->email }}</td>
                            <td><a id ="delmember_{{$member->id}}" data-popout="true" data-singleton="true" title="Confirm delete member?" data-original-title="Confirm delete member?" data-toggle="confirmation-singleton" data-placement="bottom" class="hlink"><i class="pg-trash"></i></a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No Members!</td>
                        </tr>
                    @endforelse
                  </tbody>
              </table>
              {!! $members->links() !!}
          </div>
      </div>
      <!-- END PLACE PAGE CONTENT HERE -->
  </div>
<!-- END CONTAINER FLUID -->
</div>
@endsection
@section('scripts')
    <script src="/includes/js/bootstrap-confirmation.min.js"></script>
    <script>
        //Jquery Confirm box
        $('[data-toggle="confirmation-singleton"]').confirmation({btnOkClass:'btn-xs btn-success'});

        //delete team member
        $('[data-toggle="confirmation-singleton"]').on('confirmed.bs.confirmation', function () {
            var member_id = $(this).attr('id').split("_");
            $.post("/facility/team/delete", {member: member_id[1]}, function (data) {
                if ($('.alert').length) {
                    $('.alert').remove();
                }
                if (data.mes == "done") {
                    htmlstr = '<div class="alert alert-success fade in" id="alert_div" role="alert">' +
                            '<span id="alert_msg">Member Deleted!</span>' +
                            '</div>';
                    $(htmlstr).insertAfter($('.panel-heading'));
                    $("#alert_div").fadeTo(2500, 500).slideUp(500, function () {
                        $("#alert_div").alert('close');
                        location.reload();
                    });
                }
                else {
                    htmlstr = '<div class="alert alert-danger fade in" id="alert_div" role="alert">' +
                            '<span id="alert_msg">' + data.mes + '</span>' +
                            '</div>';
                    $(htmlstr).insertAfter($('.panel-heading'));
                    $("#alert_div").fadeTo(5000, 500).slideUp(500, function () {
                        $("#alert_div").alert('close');
                    });
                }
            }, "json");

        });

        var token = "<?=csrf_token();?>";
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-Token' : token }
        });

        $('#navFclMem').addClass('active');
    </script>
@endsection