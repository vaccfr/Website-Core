@extends('layouts.app')

@section('page-title')
  Events Dashboard | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Events Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Events</span>
          <span class="info-box-number">N/A</span>
        </div>
      </div>
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Events this Month</span>
          <span class="info-box-number">N/A</span>
        </div>
      </div>
      <div class="card card-outline card-secondary">
        <div class="card-header">
          <h3 class="card-title">Tools</h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>
                  <button class="btn btn-flat btn-success btn-block" data-target="#new_event" data-toggle="modal">New Event</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal fade" id="new_event">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create new event</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.newevent', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="ne_title">Title</label>
                  <input class="form-control" type="text" name="title" id="ne_title" placeholder="Event title..." required />
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="eventdate">Date</label>
                      <input type="text" class="form-control" id="eventdate" name="date" placeholder="{{__('app/atc/atc_mybookings.date_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="starttime">Start</label>
                      <input type="text" class="form-control" id="starttime" name="starttime" placeholder="{{__('app/atc/atc_mybookings.st_time_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="endtime">End</label>
                      <input type="text" class="form-control" id="endtime" name="endtime" placeholder="{{__('app/atc/atc_mybookings.en_time_placeholder')}}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="ne_description">Description</label>
                  <textarea class="form-control" name="description" id="ne_description" rows="5" required></textarea>
                </div>
                <div class="form-group">
                  <label for="event_img">Upload image (700 x 400 px | max. 5 MB)</label>
                  <input type="file" class="form-control" id="event_img" name="event_img" accept="image/*">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.cancel')}}</button>
                <button type="submit" class="btn btn-success">{{__('app/staff/atc_mine.confirm')}}</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Events List</h3>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <th>Title</th>
              <th>Date</th>
              <th></th>
            </thead>
            <tbody>
              @if (count($events2come) > 0)
              @foreach ($events2come as $e)
              <tr>
                <td>{{$e['title']}}</td>
                <td>{{$e['date']}}</td>
                <td align="right"><button class="btn btn-info btn-flat" id="event_{{$e['id']}}">View</button></td>
              </tr>
              <script>
                $("#event_{{$e['id']}}").click(function() {
                  $("#selevent_title").text("{{$e['title']}}");
                  $("#selevent_description").text("{{$e['description']}}");
                  if ("{{$e['has_image']}}" == "1") {
                    $("#selevent_img_div").html('<img id="selevent_img" src="' + "{{config('app.url')}}/{{$e['image_url']}}" + '" alt="Event Picture" class="img-fluid" />')
                  } else {
                    $("#selevent_img_div").html('<p>(no image found for this event)</p>')
                  }
                  $("#selevent_editbtn").html('<button class="btn btn-info btn-flat float-right" type="button">Edit</button>')
                  $("#selevent_eventid").attr('value', '{{$e["id"]}}')
                  $("#selevent_delbtn").show();
                })
              </script>
              @endforeach
              @else
              <tr>
                <td>No events found</td>
                <td>-</td>
                <td align="right"><button class="btn btn-flat btn-success" data-target="#new_event" data-toggle="modal">New Event</button></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title" id="selevent_title">(no event selected)</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="selevent_description_label">Description</label>
            <textarea name="selevent_description" id="selevent_description" rows="5" class="form-control" readonly>(no event selected)</textarea>
          </div>
          <div id="selevent_img_div"></div>
        </div>
        <div class="card-footer">
          <div id="selevent_editbtn"></div>
          <div id="selevent_delbtn">
            <form id="selevent_cancelForm" action="{{ route('app.staff.events.delevent', app()->getLocale()) }}" method="post">
              @csrf
              <input type="hidden" name="eventid" id="selevent_eventid" value="">
              <button type="submit" class="btn btn-danger btn-flat">Cancel Event</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#selevent_delbtn').hide();
  d = new Date();
  flatpickr("#eventdate", {
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
</script>
@endsection