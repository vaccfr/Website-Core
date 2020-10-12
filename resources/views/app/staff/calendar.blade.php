@extends('layouts.app')

@section('page-title')
  Staff Calendar
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Staff Calendar</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-utilities@4.1.3/bootstrap-utilities.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-9">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">Staff Calendar</h3>
        </div>
        <div class="card-body p-0">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
<script>
  var Calendar = FullCalendar.Calendar;
  var calendarEl = document.getElementById('calendar');

  var calendar = new Calendar(calendarEl, {
    events    : [
      {
        title          : 'All Day Event',
        start          : new Date(y, m, 1),
        backgroundColor: '#f56954', //red
        borderColor    : '#f56954', //red
        allDay         : true
      },
      {
        title          : 'Long Event',
        start          : new Date(y, m, d - 5),
        end            : new Date(y, m, d - 2),
        backgroundColor: '#f39c12', //yellow
        borderColor    : '#f39c12' //yellow
      },
      {
        title          : 'Meeting',
        start          : new Date(y, m, d, 10, 30),
        allDay         : false,
        backgroundColor: '#0073b7', //Blue
        borderColor    : '#0073b7' //Blue
      },
      {
        title          : 'Lunch',
        start          : new Date(y, m, d, 12, 0),
        end            : new Date(y, m, d, 14, 0),
        allDay         : false,
        backgroundColor: '#00c0ef', //Info (aqua)
        borderColor    : '#00c0ef' //Info (aqua)
      },
      {
        title          : 'Birthday Party',
        start          : new Date(y, m, d + 1, 19, 0),
        end            : new Date(y, m, d + 1, 22, 30),
        allDay         : false,
        backgroundColor: '#00a65a', //Success (green)
        borderColor    : '#00a65a' //Success (green)
      },
      {
        title          : 'Click for Google',
        start          : new Date(y, m, 28),
        end            : new Date(y, m, 29),
        url            : 'http://google.com/',
        backgroundColor: '#3c8dbc', //Primary (light-blue)
        borderColor    : '#3c8dbc' //Primary (light-blue)
      }
    ],
  });
</script>
@endsection