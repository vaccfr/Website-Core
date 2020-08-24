@extends('layouts.app')

@section('page-title')
  Events Manager | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/staff/events.page_header')}}</h1>
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
        <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{__('app/staff/events.pill_one')}}</span>
          <span class="info-box-number">{{ $eventCount }}</span>
        </div>
      </div>
      <button class="btn btn-flat btn-success btn-block elevation-3" data-target="#new_event" data-toggle="modal">{{__('app/staff/events.btn_newevent')}}</button>
      <div class="modal fade" id="new_event">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/events.nev_title')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.newevent', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="ne_title">{{__('app/staff/events.nev_tit')}}</label>
                  <input class="form-control" type="text" name="title" id="ne_title" placeholder="{{__('app/staff/events.nev_tit_plac')}}" required />
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="eventdate">{{__('app/staff/events.nev_date')}}</label>
                      <input type="text" class="form-control" id="eventdate" name="date" placeholder="{{__('app/atc/atc_mybookings.date_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="starttime">{{__('app/staff/events.nev_start')}}</label>
                      <input type="text" class="form-control" id="starttime" name="starttime" placeholder="{{__('app/atc/atc_mybookings.st_time_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="endtime">{{__('app/staff/events.nev_end')}}</label>
                      <input type="text" class="form-control" id="endtime" name="endtime" placeholder="{{__('app/atc/atc_mybookings.en_time_placeholder')}}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="eventurl">{{__('app/staff/events.nev_url')}}</label>
                  <input class="form-control" type="text" name="eventurl" id="eventurl" placeholder="{{__('app/staff/events.nev_url_plac')}}" />
                </div>
                <div class="form-group">
                  <label for="ne_description">{{__('app/staff/events.nev_description')}}</label>
                  <textarea class="form-control" name="description" id="ne_description" rows="5" required placeholder="{{__('app/staff/events.nev_description_plac')}}"></textarea>
                </div>
                <div class="form-group">
                  <label for="event_img">{{__('app/staff/events.nev_img')}}</label>
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
          <h3 class="card-title">{{__('app/staff/events.evl_title')}}</h3>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <th>{{__('app/staff/events.nev_tit')}}</th>
              <th>{{__('app/staff/events.nev_date')}}</th>
              <th></th>
            </thead>
            <tbody>
              @if (count($events2come) > 0)
              @foreach ($events2come as $e)
              <tr>
                <td>{{$e['title']}}</td>
                <td>{{$e['date']}}</td>
                <td align="right"><button class="btn btn-info btn-flat" id="event_{{$e['id']}}">{{__('app/staff/events.evl_view')}}</button></td>
              </tr>
              <script>
                $("#event_{{$e['id']}}").click(function() {
                  $("#selevent_title").text("{{$e['title']}} -- {{$e['date']}} | {{$e['start_time']}} - {{$e['end_time']}}");
                  $("#selevent_description").text(`{!!$e["description"]!!}`);
                  if ("{{$e['has_image']}}" == "1") {
                    $("#selevent_img_div").html('<img id="selevent_img" src="' + "{{config('app.url')}}/{{$e['image_url']}}" + '" alt="Event Picture" class="img-fluid" />');
                    $("#edit_img_div").html('<img id="selevent_img" src="' + "{{config('app.url')}}/{{$e['image_url']}}" + '" alt="Event Picture" class="img-fluid" />');
                  } else {
                    $("#selevent_img_div").html("<p>({{__('app/staff/events.no_img')}})</p>");
                    $("#edit_img_div").html("<p>({{__('app/staff/events.no_img')}})</p>");
                  }
                  $("#selevent_editpicbtn").html('<button class="btn btn-info btn-flat float-right" type="button" data-toggle="modal" data-target="#edit_picture">{{__("app/staff/events.v_editimg")}}</button>');
                  $("#selevent_editbtn").html('<button class="btn btn-info btn-flat float-right ml-2" type="button" data-toggle="modal" data-target="#edit_event">{{__("app/staff/events.v_edit")}}</button>');
                  $("#selevent_delbtn").html('<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#delete_event">{{__("app/staff/events.v_cancel")}}</button>');
                  $("#selevent_eventid").attr('value', '{{$e["id"]}}');
                  $("#edittitle").attr('value', '{{$e["title"]}}');
                  $("#editdate").attr('value', '{{$e["date"]}}');
                  $("#editurl").attr('value', '{{$e["url"]}}');
                  $("#editstarttime").attr('value', '{{$e["start_time"]}}');
                  $("#editendtime").attr('value', '{{$e["end_time"]}}');
                  $("#editdescription").text(`{!!$e["description"]!!}`);
                  $("#editeventid").attr('value', '{{$e["id"]}}');
                  $("#editeventidimg").attr('value', '{{$e["id"]}}');
                  $("#selevent_delbtn").show();
                })
              </script>
              @endforeach
              @else
              <tr>
                <td>{{__('app/staff/events.v_noevent')}}</td>
                <td>-</td>
                <td align="right"><button class="btn btn-flat btn-success" data-target="#new_event" data-toggle="modal">{{__('app/staff/events.btn_newevent')}}</button></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-info elevation-3">
        <div class="card-header">
          <h3 class="card-title" id="selevent_title">({{__('app/staff/events.v_noevsel')}})</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="selevent_description_label">{{__('app/staff/events.nev_description')}}</label>
            <textarea name="selevent_description" id="selevent_description" rows="10" class="form-control" readonly>({{__('app/staff/events.v_noevsel')}})</textarea>
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
              <h4 class="modal-title">{{__('app/staff/events.ed_title')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.editevent', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="edittitle">{{__('app/staff/events.nev_tit')}}</label>
                  <input class="form-control" type="text" name="edittitle" id="edittitle" placeholder="{{__('app/staff/events.nev_tit_plac')}}" required />
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editdate">{{__('app/staff/events.nev_date')}}</label>
                      <input type="text" class="form-control" id="editdate" name="editdate" placeholder="{{__('app/atc/atc_mybookings.date_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editstarttime">{{__('app/staff/events.nev_start')}}</label>
                      <input type="time" class="form-control" id="editstarttime" name="editstarttime" placeholder="{{__('app/atc/atc_mybookings.st_time_placeholder')}}" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="editendtime">{{__('app/staff/events.nev_end')}}</label>
                      <input type="time" class="form-control" id="editendtime" name="editendtime" placeholder="{{__('app/atc/atc_mybookings.en_time_placeholder')}}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="editurl">{{__('app/staff/events.nev_url')}}</label>
                  <input class="form-control" type="text" name="editurl" id="editurl" placeholder="{{__('app/staff/events.nev_url_plac')}}" required />
                </div>
                <div class="form-group">
                  <label for="editdescription">{{__('app/staff/events.nev_description')}}</label>
                  <textarea class="form-control" name="editdescription" id="editdescription" rows="5" required placeholder="{{__('app/staff/events.nev_description_plac')}}"></textarea>
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
      <div class="modal fade" id="edit_picture">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/events.edi_title')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.editimg', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div id="edit_img_div"></div>
                <div class="form-group">
                  <label for="newimage">{{__('app/staff/events.nev_img')}}</label>
                  <input type="file" class="form-control" id="newimage" name="newimage" accept="image/*">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <input type="hidden" name="eventid" id="editeventidimg" value="">
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
              <h4 class="modal-title">{{__('app/staff/events.are_u_sure')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.events.delevent', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                {{__('app/staff/events.are_u_sure_2')}}
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