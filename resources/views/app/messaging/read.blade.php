@extends('app.messaging.msglayout')

@section('title')
Pigeon Voyageur | Message from Peter
@endsection

@section('header')
Inbox | Message from Peter
@endsection

@section('body')
<div class="card card-primary card-outline">
  <div class="card-header">
      <h3 class="card-title">Message from {{ $msg['sender']['fname'] }}</h3>
      @if ($msg['recipient_id'] == auth()->user()->id)
      <div class="float-right">
        <button type="button" class="btn btn-default" data-target="#send_reply" data-toggle="modal"><i class="fas fa-reply"></i> Reply</button>
      </div>
      @endif
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="mailbox-read-info">
      <h5>{{ $msg['subject'] }}</h5>
      <h6><b>From:</b> {{ $msg['sender']['fname'] }} ({{ $msg['sender']['vatsim_id'] }})
          <span class="mailbox-read-time float-right">{{ $msg['created_at'] }}</span></h6>
    </div>
    <div class="mailbox-read-message">
      {!! $msg['body'] !!}
    </div>
  </div>
  <div class="card-footer">
    @if ($msg['recipient_id'] == auth()->user()->id)
    <div class="float-right">
      <form action="{{ route('app.inmsg.archive', app()->getLocale()) }}" method="post">
        @csrf
        <input type="hidden" name="msgid" value="{{ $msg['id'] }}">
        <button type="submit" class="btn btn-default"><i class="fa fa-archive"></i> Archive</button>
      </form>
    </div>
    <form action="{{ route('app.inmsg.delete', app()->getLocale()) }}" method="post">
      @csrf
      <input type="hidden" name="msgid" value="{{ $msg['id'] }}">
      <button type="submit" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
    </form>
    @endif
  </div>
  @if ($msg['recipient_id'] == auth()->user()->id)
  <div class="modal fade" id="send_reply">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Message Draft</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('app.inmsg.reply', app()->getLocale()) }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="msgsubject">Subject</label>
              <input type="text" class="form-control" id="msgsubject" name="msgsubject" value="RE: {{ $msg['subject'] }}" required>
            </div>
            <div class="form-group">
              <label for="msgbody">Message</label>
              <textarea class="form-control" rows="15" name="msgbody" id="msgbody" placeholder="Your message" required></textarea>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <input type="hidden" name="msgrecipient" value="{{ $msg['sender_id'] }}">
            <input type="hidden" name="prevmsg_date" value="{{ $msg['created_at'] }}">
            <input type="hidden" name="prevmsg_subject" value="{{ $msg['subject'] }}">
            <input type="hidden" name="prevmsg_fname" value="{{ $msg['sender']['fname'] }}">
            <input type="hidden" name="prevmsg_lname" value="{{ $msg['sender']['lname'] }}">
            <textarea name="prevmsg_body" id="prevmsg_body" hidden>{{ $msg['body'] }}</textarea>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Send message</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection