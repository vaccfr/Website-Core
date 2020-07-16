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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Book a position</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="atc-booking-form" method="POST" action="{{ route('do.atc.booking.add', app()->getLocale()) }}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Position</label>
                <select class="form-control" id="position-select" name="positionselect">
                  <option value="" disabled selected>Select your option</option>
                  @foreach ($stations as $s)
                    <option value="{{ $s['code'] }}">{{ $s['code'] }} ({{ $s['parent']['city'] }} {{ $s['parent']['airport'] }})</option>
                  @endforeach
                </select>
              </div>
              {{-- <div class="form-group">
                <label>Position</label>
                <select class="form-control" id="positionpicker">
                  @foreach ($stations as $s)
                      <option value="{{ $s['code'] }}">{{ $s['code'] }} ({{ $s['parent']['city'] }} {{ $s['parent']['airport'] }})</option>
                  @endforeach
                </select>
              </div> --}}
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" id="booking-date" name="bookingdate" placeholder="Date">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="starttime">Start time (zulu)</label>
                    <input type="text" class="form-control" id="starttime" name="starttime" placeholder="Start time">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="endtime">End time (zulu)</label>
                    <input type="text" class="form-control" id="endtime" name="endtime" placeholder="End time">
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Your bookings</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app_indexpage.callsign')}}</th>
                <th>When</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($bookings as $b)
                  <tr>
                    <td>{{ $b['position'] }}</td>
                    <td>{{ $b['date'] }} - {{ $b['time'] }}</td>
                    <td>
                      <form action="{{ route('do.atc.booking.delete', ['locale' => app()->getLocale(), 'unique_id' => $b['unique_id']]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-block btn-danger btn-flat">Delete</button>
                      </form>
                    </td>
                  </tr>
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
  <script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
  <script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
    d = new Date();
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
    $('#positionpicker').select2();
    $('#atc-booking-form').validate({
      rules: {
        bookingdate: {
          required: true
        },
        positionselect: {
          required: true
        },
        starttime: {
          required: true
        },
        endtime: {
          required: true
        }
      },
      messages: {
        bookingdate: {
          required: "Date is required"
        },
        positionselect: {
          required: "Please select a position"
        },
        starttime: {
          required: "Please select a start time"
        },
        endtime: {
          required: "Please select an end time"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
</script>
@endsection