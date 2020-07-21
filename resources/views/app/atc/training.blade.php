@extends('layouts.app')

@section('page-title')
  ATC Training Center | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/atc/atc_training_center.header_title', ['FNAME' => Auth::user()->fname])}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="{{ asset('dashboard/stepbar.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="steps">
            <ul class="steps-container">
              <li style="width:12.5%;" class="activated">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S1 Theory</div>
                </div>
              </li>
              <li style="width:12.5%;" class="activated">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S1 CPT</div>
                </div>
              </li>
              <li style="width:12.5%;" class="activated">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S2 Theory</div>
                </div>
              </li>
              <li style="width:12.5%;" class="activated">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S2 CPT</div>
                </div>
              </li>
              <li style="width:12.5%;">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S3 Theory</div>
                </div>
              </li>
              <li style="width:12.5%;">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">S3 CPT</div>
                </div>
              </li>
              <li style="width:12.5%;">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">C1 Theory</div>
                </div>
              </li>
              <li style="width:12.5%;">
                <div class="step">
                  <div class="step-image"><span></span></div>
                  <div class="step-current">Exam</div>
                  <div class="step-description">C1 CPT</div>
                </div>
              </li>
            </ul>
            <div class="step-bar" style="width: 50%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-7">
      {{-- Upcoming training sessions table --}}
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">{{__('app/atc/atc_training_center.upcoming_sess')}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table
            id="upcoming_sessions"
            class="table table-bordered table-hover"
            data-order='[[ 1, "desc" ]]'>
            <thead>
            <tr>
              <th>{{__('app/atc/atc_training_center.callsign')}}</th>
              <th>{{__('app/atc/atc_training_center.when')}}</th>
              <th>{{__('app/atc/atc_training_center.mentor')}}</th>
              <th>{{__('app/atc/atc_training_center.prop_by')}}</th>
              <th>{{__('app/atc/atc_training_center.status')}}</th>
              <th>{{__('app/atc/atc_training_center.options')}}</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                <td>LFMN_APP</td>
                <td>DATE - TIME</td>
                <td>Peter Paré (1267123)</td>
                <td>Mentor (Peter Paré)</td>
                <td>Awaiting your approval</td>
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
                <td>Peter Paré (1267123)</td>
                <td>You</td>
                <td>Awaiting mentor approval</td>
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
    <div class="col-md-5">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">{{__('app/atc/atc_training_center.sess_req', ['MENTOR' => 'Peter Paré'])}}</h3>
        </div>
        <form action="" method="post">
          <div class="card-body">
            <div class="form-group">
              <label for="reqposition">{{__('app/atc/atc_training_center.pos')}}</label>
              <select class="form-control" name="reqposition" id="reqposition">
                <option value="" disabled selected>{{__('app/atc/atc_training_center.select')}}...</option>
              </select>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="session-date">{{__('app/atc/atc_training_center.date')}}</label>
                  <input type="text" class="form-control" id="session-date" name="sessiondate" placeholder="{{__('app/atc/atc_training_center.date')}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="starttime">{{__('app/atc/atc_training_center.st_time')}} (UTC)</label>
                  <input type="text" class="form-control" id="starttime" name="starttime" placeholder="{{__('app/atc/atc_training_center.st_time')}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="endtime">{{__('app/atc/atc_training_center.end_time')}} (UTC)</label>
                  <input type="text" class="form-control" id="endtime" name="endtime" placeholder="{{__('app/atc/atc_training_center.end_time')}}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="reqcomment">{{__('app/atc/atc_training_center.comment_for')}}</label>
              <textarea class="form-control" rows="3" name="reqcomment" id="reqcomment" style="resize: none;" placeholder="..."></textarea>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">{{__('app/atc/atc_training_center.submit')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-7">
      {{-- Past training sessions table --}}
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">{{__('app/atc/atc_training_center.past_sess')}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table
            id="past_sessions"
            class="table table-bordered table-hover"
            data-order='[[ 2, "desc" ]]'>
            <thead>
            <tr>
              <th>{{__('app/atc/atc_training_center.callsign')}}</th>
              <th>{{__('app/atc/atc_training_center.when')}}</th>
              <th>{{__('app/atc/atc_training_center.mentor')}}</th>
              <th>{{__('app/atc/atc_training_center.outcome')}}</th>
              <th>{{__('app/atc/atc_training_center.options')}}</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                <td>LFMN_TWR</td>
                <td>DATE - TIME</td>
                <td>Peter Paré (1267123)</td>
                <td>Successful</td>
                <td>
                  <form action="" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-block btn-info btn-flat">{{__('app/atc/atc_training_center.report')}}</button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>23</h3>

              <p>{{__('app/atc/atc_training_center.ment_sessions')}}</p>
            </div>
            <div class="icon">
              <i class="fas fa-headphones"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>25:34</h3>

              <p>{{__('app/atc/atc_training_center.class_h')}}</p>
            </div>
            <div class="icon">
              <i class="fas fa-clock"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>LFMN</h3>

              <p>{{__('app/atc/atc_training_center.teaching_p')}}</p>
            </div>
            <div class="icon">
              <i class="fas fa-plane-departure"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Peter Paré</h3>

              <p>{{__('app/atc/atc_training_center.curr_ment')}}</p>
            </div>
            <div class="icon">
              <i class="fas fa-chalkboard-teacher"></i>
            </div>
          </div>
        </div>
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
  flatpickr("#endtime", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      defaultHour: d.getUTCHours()+1,
      defaultMinute: 00,
      allowInput: true,
      time_24hr: true,
      minuteIncrement: 15
  });
</script>
@endsection