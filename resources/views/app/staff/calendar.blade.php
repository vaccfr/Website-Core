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
    <div class="col-md-12">
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
@foreach ($events as $e)
  <div class="modal fade" id="event_{{$e['id']}}_atcevent">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{$e['title']}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <img src="{{config('app.url')}}{{$e['image_url']}}" alt="">
            </div>
          </div>
          {{$e['description']}}
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/news.cancel')}}</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      firstDay: 1,

      events: [
        // ATC & vACC events
        @foreach ($events as $e)
        {
          title: '{{$e["title"]}}',
          start: '{{$e["start_date"]}}',
          end: '{{$e["end_date"]}}',
          uniqueID: '{{$e["id"]}}_atcevent'
        },
        @endforeach
      ],
      eventClick: function(info) {
        $('#event_' + info.event.extendedProps.uniqueID).modal('show');
      }
    });
    calendar.render();
  });
</script>
@endsection