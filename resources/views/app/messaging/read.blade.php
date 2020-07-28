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
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="mailbox-read-info">
      <h5>{{ $msg['subject'] }}</h5>
      <h6><b>From:</b> {{ $msg['sender']['fname'] }} ({{ $msg['sender']['vatsim_id'] }})
          <span class="mailbox-read-time float-right">{{ $msg['created_at'] }}</span></h6>
    </div>
    <div class="mailbox-read-message">
      {{ $msg['body'] }}
    </div>
  </div>
  <div class="card-footer">
    <div class="float-right">
      <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
      {{-- <button type="button" class="btn btn-default"><i class="fas fa-exclamation-triangle"></i> Report</button> --}}
    </div>
      <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
      <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
  </div>
</div>
@endsection