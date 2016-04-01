@extends('layouts.backend')

@section('title', 'List Facilities')

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
              <div class="panel-title">{{$facility->title}} - Offers
              </div>
              <div class="btn-group pull-right m-b-10">
                  <a href="{{ url('/facility/offer/'.$facility->id.'/create') }}" role="button" type="button" class="btn btn-primary">Add Offer</a>
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
                      <th>Title</th>
                      <th>Sub title</th>
                      <th>Alias</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($offers as $offer)
                      <tr>
                          <td class="v-align-middle semi-bold">
                              <a href="{{url('/facility/offer/edit/'.$offer->id)}}">{{ $offer->title }}</a>
                          </td>
                          <td>{{ $offer->subtitle }}</td>
                          <td>{{ $offer->alias }}</td>
                          <td><a id ="deloffer_{{$offer->id}}" data-popout="true" data-singleton="true" title="Confirm delete offer?" data-original-title="Confirm delete offer?" data-toggle="confirmation-singleton" data-placement="bottom" class="hlink"><i class="pg-trash"></i></a></td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="4">No Offers!</td>
                      </tr>
                  @endforelse
                  </tbody>
              </table>
              {!! $offers->links() !!}
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

        //delete offer - with dates
        $('[data-toggle="confirmation-singleton"]').on('confirmed.bs.confirmation', function () {
            var member_id = $(this).attr('id').split("_");
            $.post("/facility/offer/delete/"+member_id[1], {}, function (data) {
                if ($('.alert').length) {
                    $('.alert').remove();
                }
                if (data.mes == "done") {
                    htmlstr = '<div class="alert alert-success fade in" id="alert_div" role="alert">' +
                            '<span id="alert_msg">Offer Deleted!</span>' +
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

//Ajax -post token
        var token = "<?=csrf_token();?>";
        jQuery.ajaxSetup({
            headers: { 'X-CSRF-Token' : token }
        });

        $('#navFclOfr').addClass('active');
    </script>
@endsection