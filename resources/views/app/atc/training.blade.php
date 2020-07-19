@extends('layouts.app')

@section('page-title')
  ATC Training | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ATC Training Center</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      {{-- Upcoming training sessions table --}}
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Upcoming sessions</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table
            id="upcoming_sessions"
            class="table table-bordered table-hover"
            data-order='[[ 2, "desc" ]]'>
            <thead>
            <tr>
              <th>Callsign</th>
              <th>When</th>
              <th>Mentor</th>
              <th>Proposed by</th>
              <th>Options</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                <td>LFMN_APP</td>
                <td>DATE - TIME</td>
                <td>John Doe (1234567)</td>
                <td>Mentor (John Doe)</td>
                <td>
                  <form action="" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-block btn-success btn-flat"><i class="fa fa-check"></i></button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>LFMN_TWR</td>
                <td>DATE - TIME</td>
                <td>John Doe (1234567)</td>
                <td>You</td>
                <td>
                  <form action="" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-block btn-danger btn-flat"><i class="fa fa-times"></i></button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Request Training Session with {MENTOR NAME HERE}</h3>
        </div>
        <form action="" method="post">
          <div class="card-body">
            <div class="form-group">
              <label for="reqposition">Position</label>
              <select class="form-control" name="reqposition" id="reqposition">
                <option value="" disabled selected>Select...</option>
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="session-date">Date</label>
                  <input type="text" class="form-control" id="session-date" name="sessiondate" placeholder="Date">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="starttime">Start time (UTC)</label>
                  <input type="text" class="form-control" id="starttime" name="starttime" placeholder="Start time">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="reqcomment">Comment for your mentor</label>
              <textarea class="form-control" rows="3" name="reqcomment" id="reqcomment" style="resize: none;" placeholder="Comment..."></textarea>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      {{-- Past training sessions table --}}
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Past sessions</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table
            id="past_sessions"
            class="table table-bordered table-hover"
            data-order='[[ 2, "desc" ]]'>
            <thead>
            <tr>
              <th>Callsign</th>
              <th>When</th>
              <th>Mentor</th>
              <th>Outcome</th>
              <th>Options</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                <td>LFMN_TWR</td>
                <td>DATE - TIME</td>
                <td>John Doe (1234567)</td>
                <td>Successful</td>
                <td>
                  <form action="" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-block btn-info btn-flat">Report</button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $('#upcoming_sessions').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "autoWidth": false,
    "info": false,
    "scrollY": 300,
  });
  $('#past_sessions').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "autoWidth": false,
    "info": false,
    "scrollY": 300,
  });
  flatpickr("#session-date", {
      enableTime: false,
      dateFormat: "d.m.Y",
      minDate: "today",
      allowInput: true,
  });
  d = new Date();
  flatpickr("#starttime", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      defaultHour: d.getUTCHours(),
      defaultMinute: 00,
      allowInput: true,
      time_24hr: true,
      minuteIncrement: 15
  });
</script>
@endsection