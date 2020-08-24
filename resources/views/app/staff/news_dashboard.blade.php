@extends('layouts.app')

@section('page-title')
  News Manager | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>News Manager</h1>
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
      <div class="info-box elevation-3">
        <span class="info-box-icon bg-info"><i class="fas fa-newspaper"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">News Items</span>
          <span class="info-box-number"></span>
        </div>
      </div>
      <button class="btn btn-flat btn-success btn-block" data-target="#new_event" data-toggle="modal">New Item</button>
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
                  <label for="eventurl">URL</label>
                  <input class="form-control" type="text" name="eventurl" id="eventurl" placeholder="Event URL..." />
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
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">Events List</h3>
        </div>
        <div class="card-body">

        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-info elevation-3">
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
          <div id="selevent_editpicbtn"></div>
          <div id="selevent_delbtn"></div>
        </div>
      </div>
      <div class="modal fade" id="edit_event">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Event content</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.editevent', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="edittitle">Title</label>
                  <input class="form-control" type="text" name="edittitle" id="edittitle" placeholder="Event title..." required />
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editdate">Date</label>
                      <input type="text" class="form-control" id="editdate" name="editdate" placeholder="{{__('app/atc/atc_mybookings.date_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editstarttime">Start</label>
                      <input type="time" class="form-control" id="editstarttime" name="editstarttime" placeholder="{{__('app/atc/atc_mybookings.st_time_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editendtime">End</label>
                      <input type="time" class="form-control" id="editendtime" name="editendtime" placeholder="{{__('app/atc/atc_mybookings.en_time_placeholder')}}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="editdescription">Description</label>
                  <textarea class="form-control" name="editdescription" id="editdescription" rows="5" required></textarea>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <input type="hidden" name="eventid" id="editeventid" value="">
                <button type="submit" class="btn btn-danger">{{__('app/staff/atc_mine.confirm')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.cancel')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="delete_event">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/atc_mine.tm_sure')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.delevent', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                Are you sure?
              </div>
              <div class="modal-footer justify-content-between">
                <input type="hidden" name="eventid" id="selevent_eventid" value="">
                <button type="submit" class="btn btn-danger">{{__('app/staff/atc_mine.confirm')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.cancel')}}</button>
              </div>
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

  flatpickr("#editdate", {
      enableTime: false,
      dateFormat: "d.m.Y",
      minDate: "today",
      allowInput: true,
  });
</script>
@endsection