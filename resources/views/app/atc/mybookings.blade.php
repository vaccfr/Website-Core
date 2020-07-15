@extends('layouts.app')

@section('page-title')
  My ATC Bookings | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app_indexpage.welcomeback')}}, {{ Auth::user()->fname }}!</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Book a position</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Position</label>
                <select class="form-control">
                  @foreach ($stations as $s)
                      <option value="{{ $s['code'] }}">{{ $s['code'] }}</option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" id="booking-date" placeholder="Date">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="starttime">Start time (zulu)</label>
                    <input type="text" class="form-control" id="starttime" placeholder="Start time">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="endtime">End time (zulu)</label>
                    <input type="text" class="form-control" id="endtime" placeholder="End time">
                  </div>
                </div>
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is-mentoring">
                <label class="form-check-label" for="is-mentoring">Mentoring session with {MENTOR NAME HERE}</label>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        
      </div>
    </div>
  </div>
  <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    $('#atc_sessions_table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": false,
      "scrollY": 400,
    });
  </script>
  <script>
    flatpickr("#booking-date", {
        enableTime: false,
        dateFormat: "d.m.Y",
        minDate: "today",
        allowInput: true,
    });

    flatpickr("#starttime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultHour: null,
        defaultMinute: null,
        allowInput: true,
        time_24hr: true,
    });
    flatpickr("#endtime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultHour: null,
        defaultMinute: null,
        allowInput: true,
        time_24hr: true,
    });
</script>
@endsection