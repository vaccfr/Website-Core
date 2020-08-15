@extends('layouts.app')

@section('page-title')
  @yield('title')
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>@yield('header')</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
          <a href="#" class="btn btn-success btn-block mb-3 elevation-3" data-target="#send_message" data-toggle="modal">{{__('app/inmsg.compose')}}</a>

          <div class="card card-dark elevation-3">
            <div class="card-header">
              <h3 class="card-title">{{__('app/inmsg.folders')}}</h3>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="{{ route('app.inmsg.inbox', app()->getLocale()) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> {{__('app/inmsg.inbox')}}
                    @if (!session()->get('inbox_count') == 0)
                    <span class="badge bg-warning float-right">{{ session()->get('inbox_count') }}</span>
                    @endif
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('app.inmsg.sent', app()->getLocale()) }}" class="nav-link">
                    <i class="far fa-envelope"></i> {{__('app/inmsg.sent')}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('app.inmsg.archive', app()->getLocale()) }}" class="nav-link">
                    <i class="fa fa-archive"></i> {{__('app/inmsg.archived')}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('app.inmsg.trash', app()->getLocale()) }}" class="nav-link">
                    <i class="far fa-trash-alt"></i> {{__('app/inmsg.trash')}}
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <div class="modal fade" id="send_message">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{__('app/inmsg.comp_title')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('app.inmsg.send', app()->getLocale()) }}" method="post">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label for="msgrecipient">{{__('app/inmsg.comp_recip')}}</label>
                    <select class="form-control" name="msgrecipient" id="msgrecipient" required>
                      <option value="" disabled selected>{{__('app/inmsg.comp_recip')}}</option>
                      @foreach ($recipientList as $r)
                        <option value="{{ $r['value'] }}">{{ $r['verbose'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="msgsubject">{{__('app/inmsg.comp_subject')}}</label>
                    <input type="text" class="form-control" id="msgsubject" name="msgsubject" placeholder="{{__('app/inmsg.comp_subject')}}" required>
                  </div>
                  <div class="form-group">
                    <label for="msgbody">{{__('app/inmsg.comp_msg')}}</label>
                    <textarea class="form-control" rows="15" name="msgbody" id="msgbody" placeholder="{{__('app/inmsg.comp_your_msg')}}" required></textarea>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/inmsg.comp_close')}}</button>
                  <button type="submit" class="btn btn-success">{{__('app/inmsg.comp_send_msg')}}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          @yield('body')
        </div>
    </div>
</div>
@endsection