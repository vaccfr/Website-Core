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
          <h1>{{__('app/atc/atc_mybookings.header_title', ['FNAME' => Auth::user()->fname])}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/atc/atc_mybookings.book_a_pos')}}</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="atc-booking-form" method="POST" action="{{ route('do.atc.booking.add', app()->getLocale()) }}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>{{__('app/atc/atc_mybookings.pos_label')}}</label>
                <select class="form-control selectPosition" id="position-select" name="positionselect">
                  <option value=""></option>
                  @foreach ($positions as $p)
                    @if (count($p['positions']) > 0)
                      <optgroup label="{{ $p['city'] }} {{ $p['airport'] }}"></optgroup>
                      @foreach ($p['positions'] as $s)
                        <option value="{{ $s['code'] }}">{{ $s['code'] }}</option>
                      @endforeach
                      <optgroup label=""></optgroup>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="date">{{__('app/atc/atc_mybookings.date_label')}}</label>
                    <input type="text" class="form-control" id="booking-date" name="bookingdate" placeholder="{{__('app/atc/atc_mybookings.date_placeholder')}}">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="starttime">{{__('app/atc/atc_mybookings.st_time_label')}}</label>
                    <input type="text" class="form-control" id="starttime" name="starttime" placeholder="{{__('app/atc/atc_mybookings.st_time_placeholder')}}">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="endtime">{{__('app/atc/atc_mybookings.en_time_label')}}</label>
                    <input type="text" class="form-control" id="endtime" name="endtime" placeholder="{{__('app/atc/atc_mybookings.en_time_placeholder')}}">
                  </div>
                </div>
              </div>
              @if ($isMentored == true)
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is-mentoring" name="ismentoring">
                <label class="form-check-label" for="is-mentoring">{{__('app/atc/atc_mybookings.mentor_checkbox', ['NAME' => $mentorName])}}</label>
              </div>
              @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">{{__('app/atc/atc_mybookings.submit_btn')}}</button>
            </div>
          </form>
        </div>
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">Bookings</h3>
          </div>
          <div class="card-body">
            <table
              id="bookings_today"
              class="table table-hover mt-3"
              data-order='[[ 2, "asc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/atc/atc_allbookings.position')}}</th>
                <th>{{__('app/atc/atc_allbookings.name')}}</th>
                <th>{{__('app/atc/atc_allbookings.hours')}}</th>
                <th>{{__('app/atc/atc_allbookings.rating')}}</th>
                <th>{{__('app/atc/atc_allbookings.mentoring')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($bookingToday as $b)
                  <tr>
                    <td>{{$b['position']}}</td>
                    <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                    <td>{{date_create_from_format('Y-m-d H:i:s', $b['start_date'])->format('H:i')}}z - {{date_create_from_format('Y-m-d H:i:s', $b['end_date'])->format('H:i')}}z</td>
                    <td>{{$b['user']['atc_rating_short']}}</td>
                    <td>@if ($b['training'] == true)
                      <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                    @else
                      <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                    @endif</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/atc/atc_mybookings.your_bk_title')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-hover"
              data-order='[[ 1, "asc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/atc/atc_mybookings.callsign')}}</th>
                <th>{{__('app/atc/atc_mybookings.when_date')}}</th>
                <th>Mentoring</th>
                <th>{{__('app/atc/atc_mybookings.actions_col')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($myBookings as $b)
                  <tr>
                    <td>{{ $b['position'] }}</td>
                    <td>{{ date_create_from_format('Y-m-d H:i:s', $b['start_date'])->format('d.m.Y H:i') }}z - {{ date_create_from_format('Y-m-d H:i:s', $b['end_date'])->format('H:i') }}z</td>
                    <td>
                      @if ($b['training'] == true)
                      <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                      <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                      @endif
                    </td>
                    <td>
                      <form action="{{ route('do.atc.booking.delete', ['locale' => app()->getLocale(), 'unique_id' => $b['unique_id']]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-block btn-danger btn-flat">{{__('app/atc/atc_mybookings.del_btn')}}</button>
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
      "paging": false,
      "info": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": false,
      "scrollY": 575,
      "language": {
        "emptyTable": "Pas de bookings trouvés"
      }
    });
    $('#bookings_today').DataTable({
      "paging": false,
      "info": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": false,
      "scrollY": 225,
      "language": {
        "emptyTable": "Pas de bookings trouvés"
      }
    });
    $('.selectPosition').select2({
      placeholder: "{{__('app/atc/atc_mybookings.pos_select')}}"
    })
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