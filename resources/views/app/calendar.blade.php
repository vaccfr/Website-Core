@extends('layouts.app')

@section('page-title')
  Calendar
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/user/index.c_header')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="{{asset('dashboard/fullcalendar/lib/main.min.css')}}">
<script src="{{asset('dashboard/fullcalendar/lib/main.min.js')}}"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-dark card-outline elevation-3">
        <div class="card-body p-0">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@foreach ($events as $e)
  <div class="modal fade" id="event_{{$e['id']}}_atcevent">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{$e['title']}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="{{config('app.url')}}{{$e['image_url']}}" alt="Image for event: {{$e['title']}}" class="img-fluid">
          <div class="form-group">
            <label for="event_description">{{__('app/staff/events.nev_description')}}</label>
            <textarea name="event_description" id="event_description" rows="10" class="form-control" readonly>{{$e['description']}}</textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/news.cancel')}}</button>
          {{-- <button type="submit" class="btn btn-success">Submit</button> --}}
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
      height: 650,

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
      },
      eventTimeFormat: {
        hour: 'numeric',
        minute: '2-digit',
        meridiem: false
      }
    });
    calendar.render();
  });
</script>
@endsection