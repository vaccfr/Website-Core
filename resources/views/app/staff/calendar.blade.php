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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css" integrity="sha256-uq9PNlMzB+1h01Ij9cx7zeE2OR2pLAfRw3uUUOOPKdA=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js" integrity="sha256-mMw9aRRFx9TK/L0dn25GKxH/WH7rtFTp+P9Uma+2+zc=" crossorigin="anonymous"></script>
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      firstDay: 1,

      events: [
        {
          title: 'All Day Event',
          start: '2020-10-24T08:00:00Z',
          end: '2020-10-25T10:00:00Z',
          uniqueID: 'TEST123'
        },
      ],
      eventClick: function(info) {
        console.log(info);
        alert('Event: ' + info.event.extendedProps.uniqueID);
      }
    });
    calendar.render();
  });
</script>
@endsection