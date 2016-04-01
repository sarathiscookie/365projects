@extends('layouts.backend')

@section('title', 'List Facilities')

@section('content')
<div class="content">
<!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg bg-white">
      <!-- BEGIN PlACE PAGE CONTENT HERE -->
      <div class="panel panel-transparent">
          <div class="panel-heading">
              <div class="panel-title">Facilities
              </div>
              <div class="btn-group pull-right m-b-10">
                  <a href="{{url('/facilities/create')}}" role="button" type="button" class="btn btn-primary">Add Facility</a>
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
                      <th>Project</th>
                      <th>Gallery</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($facilities as $facility)
                        <tr>
                            <td class="v-align-middle semi-bold">
                                <a href="{{url('/facilities/edit/'.$facility->id)}}">{{ $facility->title }}</a>
                            </td>
                            <td>{{ $facility->project }}</td>
                            <td>
                                <a href="{{url('/facilities/images/'.$facility->id)}}"><i class="fs-14  pg-image"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No Facilities!</td>
                        </tr>
                    @endforelse
                  </tbody>
              </table>
              {!! $facilities->links() !!}
          </div>
      </div>
      <!-- END PLACE PAGE CONTENT HERE -->
  </div>
<!-- END CONTAINER FLUID -->
</div>
@endsection