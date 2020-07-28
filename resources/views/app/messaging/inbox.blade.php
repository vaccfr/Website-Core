@extends('app.messaging.msglayout')

@section('title')
Pigeon Voyageur | Inbox
@endsection

@section('header')
Inbox
@endsection

@section('body')
<div class="card card-primary card-outline">
  <div class="card-header">
      <h3 class="card-title">Inbox</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
      </div>
      <!-- /.card-tools -->
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
            <tbody>
              @forelse ($display as $d)
              <tr>
                <td class="mailbox-name">
                  <form id="msg_id_{{ $d['id'] }}" action="{{ route('app.inmsg.inbox.read', ['locale' => app()->getLocale()]) }}" method="get">
                    <input type="hidden" value="{{ $d['id'] }}" name="msgid">
                    <a href="javascript:$('#msg_id_{{ $d['id'] }}').submit();">
                      {{ $d['sender']['fname'] }} {{ $d['sender']['lname'] }}
                    </a>
                  </form>
                </td>
                <td class="mailbox-subject"><b>{{ $d['subject'] }}</b>
                </td>
                <td class="mailbox-date">{{ $d['created_at'] }}</td>
                <td>
                  @if ($d['read'] == false)
                  <span class="badge bg-warning float-right"><i class="fa fa-exclamation"></i></span>
                  @else
                  <span class="badge bg-success float-right"><i class="fa fa-check"></i></span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td>
                  No messages
                </td>
              </tr> 
              @endforelse
            </tbody>
        </table>
      </div>
  </div>
  <div class="card-footer p-0">

  </div>
</div>
@endsection