@extends('layouts.app')

@section('page-title')
  ATC Mentoring | My students
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ATC Mentoring - My students</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="{{ asset('dashboard/stepbar.css') }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Students</span>
            <span class="info-box-number">1</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Sessions</span>
            <span class="info-box-number">7</span>
          </div>
        </div>
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">Mentor's toolbox</h3>
          </div>
          <div class="card-body p-0">
            <table class="table">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Powerpoint utile</a></td>
                </tr>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Videos de chats</a></td>
                </tr>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Photos de Philippe devant le scope</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
        <script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
        <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        @foreach ($students as $s)
        <div class="card card-outline @if(true) card-success @else card-danger @endif">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">{{ $s['user']['fname'] }} {{ $s['user']['lname'] }} - {{ $s['user']['atc_rating_short'] }} - {{ $s['mentoringRequest']['icao'] }}</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h4>{{ $s['user']['fname'] }}'s progress</h4>
                <div class="steps">
                  <ul class="steps-container">
                    @foreach ($steps as $step)
                    @php
                      $progCurrent = $s['progress'] * $progSteps;
                      $now = ($loop->index + 1)*$progSteps;
                      if ($now > $progCurrent) {
                        $now = false;
                      } else {
                        $now = true;
                      }
                    @endphp
                    <li style="width:{{ $progSteps }}%;" @if ($now) class="activated" @endif>
                      <div class="step">
                        <div class="step-image"><span></span></div>
                        <div class="step-current">{{ $step['type'] }}</div>
                        <div class="step-description">{{ $step['title'] }}</div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  <div class="step-bar" style="width: {{ $progCurrent }}%;"></div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-7 border-right">
                <h4>Upcoming sessions</h4>
                <table
                  id="upcoming_sessions_{{ $s['user']['vatsim_id'] }}"
                  class="table table-bordered table-hover"
                  data-order='[[ 1, "desc" ]]'>
                  <thead>
                  <tr>
                    <th>Position</th>
                    <th>When</th>
                    <th>Scheduled by</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>LFMN_APP</td>
                      <td>DATE - TIME</td>
                      <td>Student (Emmanuel Macron)</td>
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
                      <td>You</td>
                      <td>Awaiting student approval</td>
                      <td>
                        <form action="" method="GET">
                          @csrf
                          <button type="submit" class="btn btn-block btn-danger btn-flat"><i class="fa fa-times"></i></button>
                        </form>
                      </td>
                    </tr>
                    <tr>
                      <td>LFMN_TWR</td>
                      <td>DATE - TIME</td>
                      <td>You</td>
                      <td>Awaiting report</td>
                      <td>
                        <form action="" method="GET">
                          @csrf
                          <button type="submit" class="btn btn-block btn-info btn-flat"><i class="fa fa-edit"></i></button>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-5">
                <h4>Past sessions</h4>
                <table
                  id="past_sessions_{{ $s['user']['vatsim_id'] }}"
                  class="table table-bordered table-hover"
                  data-order='[[ 1, "desc" ]]'>
                  <thead>
                  <tr>
                    <th>Position</th>
                    <th>When</th>
                    <th>Outcome</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>LFMN_TWR</td>
                      <td>DATE - TIME</td>
                      <td>Successful</td>
                      <td>
                        <form action="" method="GET">
                          @csrf
                          <button type="submit" class="btn btn-block btn-info btn-flat">See Report</button>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#book-session-{{ $s['user']['vatsim_id'] }}">Book Session</button>
            <button type="button" class="btn btn-warning btn-flat">Edit Progress</button>
            <button type="button" class="btn btn-danger btn-flat">Release Student</button>
            <button type="button" class="btn btn-danger btn-flat">Terminate Mentoring</button>
          </div>
        </div>
        <div class="modal fade" id="book-session-{{ $s['user']['vatsim_id'] }}">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Book a session with {{ $s['user']['fname'] }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('app.staff.atc.mine.booksession', app()->getLocale()) }}" method="post">
                @csrf
                <div class="modal-body">
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
                        <input type="text" class="form-control" id="session-date-{{ $s['user']['vatsim_id'] }}" name="sessiondate" placeholder="{{__('app/atc/atc_training_center.date')}}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="starttime">{{__('app/atc/atc_training_center.st_time')}} (UTC)</label>
                        <input type="text" class="form-control" id="starttime-{{ $s['user']['vatsim_id'] }}" name="starttime" placeholder="{{__('app/atc/atc_training_center.st_time')}}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="endtime">{{__('app/atc/atc_training_center.end_time')}} (UTC)</label>
                        <input type="text" class="form-control" id="endtime-{{ $s['user']['vatsim_id'] }}" name="endtime" placeholder="{{__('app/atc/atc_training_center.end_time')}}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="reqcomment">{{__('app/atc/atc_training_center.comment_for')}}</label>
                    <textarea class="form-control" rows="3" name="reqcomment" id="reqcomment" style="resize: none;" placeholder="..."></textarea>
                  </div>
                </div>
                <input type="hidden" name="userid" value="{{ $s['user']['id'] }}">
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Send request</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script>
          $("#upcoming_sessions_{{ $s['user']['vatsim_id'] }}").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "scrollY": 300,
          });
          $("#past_sessions_{{ $s['user']['vatsim_id'] }}").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "scrollY": 300,
          });
          flatpickr("#session-date-{{ $s['user']['vatsim_id'] }}", {
              enableTime: false,
              dateFormat: "d.m.Y",
              minDate: "today",
              allowInput: true,
          });
          d = new Date();
          flatpickr("#starttime-{{ $s['user']['vatsim_id'] }}", {
              enableTime: true,
              noCalendar: true,
              dateFormat: "H:i",
              defaultHour: d.getUTCHours(),
              defaultMinute: 00,
              allowInput: true,
              time_24hr: true,
              minuteIncrement: 15
          });
          flatpickr("#endtime-{{ $s['user']['vatsim_id'] }}", {
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
        @endforeach
      </div>
    </div>
  </div>
@endsection