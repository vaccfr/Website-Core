@extends('app.messaging.msglayout')

@section('title')
{{__('app/inmsg.page_title', ['FNAME' => $msg['sender']['fname']])}}
@endsection

@section('header')
{{__('app/inmsg.page_title', ['FNAME' => $msg['sender']['fname']])}}
@endsection

@section('body')
<div class="card card-primary card-outline elevation-3">
  <div class="card-header">
      <h3 class="card-title">{{__('app/inmsg.mail_title', ['FNAME' => $msg['sender']['fname']])}}</h3>
      @if ($msg['recipient_id'] == auth()->user()->id)
      <div class="float-right">
        <button type="button" class="btn btn-default" data-target="#send_reply" data-toggle="modal"><i class="fas fa-reply"></i> {{__('app/inmsg.mail_reply')}}</button>
      </div>
      @endif
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="mailbox-read-info">
      <h5>{{ $msg['subject'] }}</h5>
      <h6><b>{{__('app/inmsg.mail_from')}}:</b> {{ $msg['sender']['fname'] }} ({{ $msg['sender']['vatsim_id'] }})
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
        <button type="submit" class="btn btn-default"><i class="fa fa-archive"></i> {{__('app/inmsg.mail_archive')}}</button>
      </form>
    </div>
    <form action="{{ route('app.inmsg.delete', app()->getLocale()) }}" method="post">
      @csrf
      <input type="hidden" name="msgid" value="{{ $msg['id'] }}">
      <button type="submit" class="btn btn-default"><i class="far fa-trash-alt"></i> {{__('app/inmsg.mail_delete')}}</button>
    </form>
    @endif
  </div>
  @if ($msg['recipient_id'] == auth()->user()->id)
  <div class="modal fade" id="send_reply">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('app/inmsg.comp_title')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('app.inmsg.reply', app()->getLocale()) }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="msgsubject">{{__('app/inmsg.comp_subject')}}</label>
              <input type="text" class="form-control" id="msgsubject" name="msgsubject" value="RE: {{ $msg['subject'] }}" required>
            </div>
            <div class="form-group">
              <label for="msgbody">{{__('app/inmsg.comp_msg')}}</label>
              <textarea class="form-control" rows="15" name="msgbody" id="msgbody" placeholder="{{__('app/inmsg.comp_your_msg')}}" required></textarea>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <input type="hidden" name="msgrecipient" value="{{ $msg['sender_id'] }}">
            <input type="hidden" name="prevmsg_date" value="{{ $msg['created_at'] }}">
            <input type="hidden" name="prevmsg_subject" value="{{ $msg['subject'] }}">
            <input type="hidden" name="prevmsg_fname" value="{{ $msg['sender']['fname'] }}">
            <input type="hidden" name="prevmsg_lname" value="{{ $msg['sender']['lname'] }}">
            <textarea name="prevmsg_body" id="prevmsg_body" hidden>{{ $msg['body'] }}</textarea>
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/inmsg.comp_close')}}</button>
            <button type="submit" class="btn btn-success">{{__('app/inmsg.comp_send_msg')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection