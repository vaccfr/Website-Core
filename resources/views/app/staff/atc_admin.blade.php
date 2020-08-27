@extends('layouts.app')

@section('page-title')
  ATC Admin
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/admin/atc_admin.header_title')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/admin/atc_admin.pill_one')}}</span>
            <span class="info-box-number">{{ $rosterCount }}</span>
          </div>
        </div>
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/admin/atc_admin.pill_two')}}</span>
            <span class="info-box-number">{{ $approvedRosterCount }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <!-- /.card -->
        <div class="card card-dark collapsed-card elevation-3">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">ATC Requests</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="request_atc"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>Submitted</th>
                <th>Who</th>
                <th>When</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Details</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($atcrequests as $atcr)
                  <tr>
                    <td>{{$atcr['created_at']}}</td>
                    <td>{{$atcr['name']}} ({{$atcr['vatsim_id']}})</td>
                    <td>{{$atcr['event_date']}}</td>
                    <td>{{$atcr['dep_airport_and_time']}}</td>
                    <td>{{$atcr['arr_airport_and_time']}}</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#request_{{ $atcr['id'] }}">
                        <i class="far fa-eye"></i>
                      </button>
                    </td>
                    <td>
                      @if ($atcr['assigned'] == true)
                      <span class="badge bg-success"><i class="fa fa-check"></i> Confirmed</span>
                      @else
                      <span class="badge bg-warning"><i class="fa fa-times"></i> Pending</span>
                      @endif
                    </td>
                  </tr>
                  <div class="modal fade" id="request_{{ $atcr['id'] }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{$atcr['event_name']}}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="dep{{ $atcr['id'] }}">Departure</label>
                                <input type="text" class="form-control" id="dep{{ $atcr['id'] }}" disabled value="{{ $atcr['dep_airport_and_time'] }}">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="arr{{ $atcr['id'] }}">Arrival</label>
                                <input type="text" class="form-control" id="arr{{ $atcr['id'] }}" disabled value="{{ $atcr['arr_airport_and_time'] }}">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="pilots{{ $atcr['id'] }}">Expected Pilots</label>
                                <input type="text" class="form-control" id="pilots{{ $atcr['id'] }}" disabled value="{{ $atcr['expected_pilots'] }}">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="url{{ $atcr['id'] }}">URL</label>
                                <input type="text" id="url{{ $atcr['id'] }}" class="form-control" disabled value="{{ $atcr['event_website'] }}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="email{{ $atcr['id'] }}">Contact Email</label>
                                <input type="text" id="email{{ $atcr['id'] }}" class="form-control" disabled value="{{ $atcr['email'] }}">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="route{{ $atcr['id'] }}">Route</label>
                            <textarea name="route{{ $atcr['id'] }}" id="route{{ $atcr['id'] }}" class="form-control" style="resize: none;" rows="5" disabled>{{ $atcr['route'] }}</textarea>
                          </div>
                          <div class="form-group">
                            <label for="pos{{ $atcr['id'] }}">Positions</label>
                            <textarea name="pos{{ $atcr['id'] }}" id="pos{{ $atcr['id'] }}" class="form-control" style="resize: none;" rows="2" disabled>{!! nl2br($atcr['requested_positions']) !!}</textarea>
                          </div>
                          <div class="form-group">
                            <label for="msg{{ $atcr['id'] }}">Message</label>
                            <textarea name="msg{{ $atcr['id'] }}" id="msg{{ $atcr['id'] }}" class="form-control" style="resize: none;" rows="5" disabled>{!! nl2br($atcr['message']) !!}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.close')}}</button>
                          @if ($atcr['assigned'] == false)
                            <form action="{{ route('app.staff.atcadmin.v', app()->getLocale()) }}" method="post">
                              @csrf
                              <input type="hidden" name="reqid" value="{{$atcr['id']}}">
                              <button type="submit" class="btn btn-success">Valider</button>
                            </form>
                          @else
                            <form action="{{ route('app.staff.atcadmin.r', app()->getLocale()) }}" method="post">
                              @csrf
                              <input type="hidden" name="reqid" value="{{$atcr['id']}}">
                              <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-dark collapsed-card elevation-3">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">{{__('app/admin/atc_admin.roster_members')}}</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_roster_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/admin/atc_admin.cid')}}</th>
                <th>{{__('app/admin/atc_admin.name')}}</th>
                <th>{{__('app/admin/atc_admin.rating')}}</th>
                <th>{{__('app/admin/atc_admin.approved')}}</th>
                <th>{{__('app/admin/atc_admin.authorised')}} LFPG TWR</th>
                <th>{{__('app/admin/atc_admin.authorised')}} LFPG APP</th>
                <th>{{__('app/admin/atc_admin.authorised')}} LFMN TWR</th>
                <th>{{__('app/admin/atc_admin.authorised')}} LFMN APP</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($roster as $r)
                  <tr>
                    <td>{{ $r['vatsim_id'] }}</td>
                    <td>{{ $r['fname'] }} {{ $r['lname'] }}</td>
                    <td>{{ $r['rating_short'] }}</td>
                    <td>@if ($r['approved_flag'] == true)
                      <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                      <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                    @endif</td>
                    <td>@if ($r['appr_lfpg_twr'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_twr">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.remove')}}</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_twr">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> {{__('app/admin/atc_admin.add')}}</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfpg_app'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_app">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.remove')}}</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_app">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> {{__('app/admin/atc_admin.add')}}</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfmn_twr'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_twr">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.remove')}}</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_twr">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> {{__('app/admin/atc_admin.add')}}</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfmn_app'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_app">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.remove')}}</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_app">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> {{__('app/admin/atc_admin.add')}}</button>
                      </form>
                    @endif</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-dark collapsed-card elevation-3">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">{{__('app/admin/atc_admin.solo_appr')}}</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="solo_approved"
              class="table table-bordered table-hover"
              data-order='[[ 1, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/admin/atc_admin.cid')}}</th>
                <th>{{__('app/admin/atc_admin.name')}}</th>
                <th>{{__('app/admin/atc_admin.rating')}}</th>
                <th>{{__('app/admin/atc_admin.position')}}</th>
                <th>{{__('app/admin/atc_admin.start')}}</th>
                <th>{{__('app/admin/atc_admin.end')}}</th>
                <th>{{__('app/admin/atc_admin.mentor')}}</th>
                <th>{{__('app/admin/atc_admin.options')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($soloApproved as $solo)
                <tr>
                  <td>{{ $solo['user']['vatsim_id'] }}</td>
                  <td>{{ $solo['user']['fname'] }} {{ $solo['user']['lname'] }}</td>
                  <td>{{ $solo['user']['atc_rating_short'] }}</td>
                  <td>{{ $solo['position'] }}</td>
                  <td>{{ $solo['start_date'] }}</td>
                  <td>{{ $solo['end_date'] }}</td>
                  <td>{{ $solo['mentor']['user']['fname'] }} {{ $solo['mentor']['user']['lname'] }}</td>
                  <td>
                    <form action="{{ route('app.staff.atcadmin.delsolo', app()->getLocale()) }}" method="POST">
                      @csrf
                      <input type="hidden" name="soloid" value="{{ $solo['id'] }}">
                      <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.delete')}}</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-dark collapsed-card elevation-3">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">{{__('app/admin/atc_admin.mentoring_reqs')}}</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="mentoring_requests"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/admin/atc_admin.cid')}}</th>
                <th>{{__('app/admin/atc_admin.name')}}</th>
                <th>{{__('app/admin/atc_admin.rating')}}</th>
                <th>{{__('app/admin/atc_admin.region')}}</th>
                <th>{{__('app/admin/atc_admin.airport')}}</th>
                <th>{{__('app/admin/atc_admin.motiv')}}</th>
                <th>{{__('app/admin/atc_admin.mentor')}}</th>
                <th>{{__('app/admin/atc_admin.options')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($apps as $a)
                  <tr>
                    <td>{{ $a['user']['vatsim_id'] }}</td>
                    <td>{{ $a['user']['fname'] }} {{ $a['user']['lname'] }}</td>
                    <td>{{ $a['user']['atc_rating_short'] }}</td>
                    <td>{{ $a['user']['subdiv_id'] }} {{ $a['user']['subdiv_name'] }}</td>
                    <td>{{ $a['icao'] }}</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#motiv_modal_{{ $a['user']['vatsim_id'] }}">
                        {{__('app/admin/atc_admin.motiv')}}
                      </button>
                    </td>
                    <td>
                      @if ($a['mentor_id'] == null)
                      {{__('app/admin/atc_admin.no_mentor')}}
                      @else
                        {{ $a['mentor']['user']['fname'] }} {{ $a['mentor']['user']['lname'] }}
                      @endif
                    </td>
                    <td>
                      <form action="{{ route('app.staff.atcadmin.delapplication', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="appid" value="{{ $a['id'] }}">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> {{__('app/admin/atc_admin.delete')}}</button>
                      </form>
                    </td>
                  </tr>
                  <div class="modal fade" id="motiv_modal_{{ $a['user']['vatsim_id'] }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{ $a['user']['fname'] }}'s Motivation</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>{{ $a['motivation'] }}</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $('#request_atc').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#atc_roster_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#solo_approved').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#mentoring_requests').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  </script>
@endsection