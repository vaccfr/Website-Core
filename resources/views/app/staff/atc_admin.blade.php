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
          <h1>ATC Admin</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Roster Members</span>
            <span class="info-box-number">{{ $rosterCount }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Approved ATC</span>
            <span class="info-box-number">{{ $approvedRosterCount }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <!-- /.card -->
        <div class="card card-outline card-primary">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">Roster Members</h3>
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
                <th>Name</th>
                <th>Vatsim ID</th>
                <th>ATC Rating</th>
                <th>Approved ATC</th>
                <th>Authorised LFPG TWR</th>
                <th>Authorised LFPG APP</th>
                <th>Authorised LFMN TWR</th>
                <th>Authorised LFMN APP</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($roster as $r)
                  <tr>
                    <td>{{ $r['fname'] }} {{ $r['lname'] }}</td>
                    <td>{{ $r['vatsim_id'] }}</td>
                    <td>{{ $r['rating_short'] }}</td>
                    <td>@if ($r['approved_flag'] == true)
                        Yes
                    @else
                        No
                    @endif</td>
                    <td>@if ($r['appr_lfpg_twr'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_twr">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Remove</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_twr">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Add</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfpg_app'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_app">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Remove</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfpg_app">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Add</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfmn_twr'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_twr">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Remove</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_twr">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Add</button>
                      </form>
                    @endif</td>

                    <td>@if ($r['appr_lfmn_app'] == true)
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_app">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Remove</button>
                      </form>
                    @else
                      <form action="{{ route('app.staff.atcadmin.approval', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $r['id'] }}">
                        <input type="hidden" name="position" value="lfmn_app">
                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Add</button>
                      </form>
                    @endif</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-outline card-primary">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">Solo Validations</h3>
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
                <th>{{__('app/atc/rosters.cid')}}</th>
                <th>{{__('app/atc/rosters.name')}}</th>
                <th>{{__('app/atc/rosters.rating')}}</th>
                <th>{{__('app/atc/rosters.position')}}</th>
                <th>{{__('app/atc/rosters.start')}}</th>
                <th>{{__('app/atc/rosters.end')}}</th>
                <th>{{__('app/atc/rosters.mentor')}}</th>
                <th>Options</th>
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
                      <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-outline card-primary">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">Mentoring Request</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>Name</th>
                <th>Vatsim ID</th>
                <th>ATC Rating</th>
                <th>Region</th>
                <th>Airport</th>
                <th>Motivation</th>
                <th>Mentor</th>
                <th>Options</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($apps as $a)
                  <tr>
                    <td>{{ $a['user']['fname'] }} {{ $a['user']['lname'] }}</td>
                    <td>{{ $a['user']['vatsim_id'] }}</td>
                    <td>{{ $a['user']['atc_rating_short'] }}</td>
                    <td>{{ $a['user']['subdiv_id'] }} {{ $a['user']['subdiv_name'] }}</td>
                    <td>{{ $a['icao'] }}</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#motiv_modal_{{ $a['user']['vatsim_id'] }}">
                        Motivation
                      </button>
                    </td>
                    <td>
                      @if ($a['mentor_id'] == null)
                        (no mentor)
                      @else
                        {{ $a['mentor']['user']['fname'] }} {{ $a['mentor']['user']['lname'] }}
                      @endif
                    </td>
                    <td>
                      <form action="{{ route('app.staff.atcadmin.delapplication', app()->getLocale()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="appid" value="{{ $a['id'] }}">
                        <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Delete</button>
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
  </script>
@endsection