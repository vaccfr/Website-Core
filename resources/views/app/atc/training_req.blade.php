@extends('layouts.app')

@section('page-title')
  ATC Training Center | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/atc/atc_training_center_req.header_title', ['FNAME' => Auth::user()->fname])}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">{{__('app/atc/atc_training_center_req.welcome_title') }}</h3>
        </div>
        <div class="card-body">
          {!! __('app/atc/atc_training_center_req.welcome_msg') !!}
        </div>
        <div class="card-footer">
          <i style="font-size: 14px">{{__('app/atc/atc_training_center_req.welcome_submsg') }}</i>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-info elevation-3">
        <div class="card-header">
          <h3 class="card-title">{{__('app/atc/atc_training_center_req.form_title') }}</h3>
        </div>
        @switch($show)
            @case("NORMAL")
              <form action="{{ route('app.atc.training.mentoringRequest', app()->getLocale()) }}" method="post" id="mentoring-request-form" name="mentoring-request-form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="reqposition">{{__('app/atc/atc_training_center_req.choose_pos') }}</label>
                    <select class="form-control" name="reqposition" id="reqposition">
                      <option value="" disabled selected>{{__('app/atc/atc_training_center_req.select') }}...</option>
                      @foreach ($platforms as $p)
                        @if (!in_array($p['icao'], $excl) && $p['airport'] != "CENTRE"))
                          <option value="{{ $p['icao'] }}">{{ $p['icao'] }} ({{ $p['city'] }} {{ $p['airport'] }})</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="reqmotivation">{{__('app/atc/atc_training_center_req.your_motiv') }}</label>
                    <textarea class="form-control" rows="5" name="reqmotivation" id="reqmotivation" style="resize: none;" placeholder="{{__('app/atc/atc_training_center_req.strt_typ') }}..."></textarea>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="reqallowmail" name="reqallowmail">
                      <label class="custom-control-label" for="reqallowmail">{{__('app/atc/atc_training_center_req.allowmail') }}</label>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">{{__('app/atc/atc_training_center_req.submit') }}</button>
                </div>
              </form>
              @break
            
            @case("NOREGION")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">{!!__('app/atc/atc_training_center_req.err_noregion') !!}</p>
              </div>
              @break
            @case("APPLIED")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">{{__('app/atc/atc_training_center_req.err_applied') }}</p>
                <div class="form-group">
                  <label for="reqposition">{{__('app/atc/atc_training_center_req.choose_pos') }}</label>
                  <select class="form-control" name="reqposition" id="reqposition" disabled>
                    <option value="" disabled selected>{{ $mRequest->icao }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="reqmotivation">{{__('app/atc/atc_training_center_req.your_motiv') }}</label>
                  <textarea class="form-control" rows="5" name="reqmotivation" id="reqmotivation" style="resize: none;" placeholder="{{ $mRequest->motivation }}" disabled></textarea>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="reqallowmail" name="reqallowmail" disabled @if ($mRequest->mail_consent == true) checked @endif>
                    <label class="custom-control-label" for="reqallowmail">{{__('app/atc/atc_training_center_req.allowmail') }}</label>
                  </div>
                </div>
              </div>
              @break
            
            @case("CLOSED")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">{{__('app/atc/atc_training_center_req.closed_msg') }}</p>
              </div>
              @break
            @default
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">{{__('app/atc/atc_training_center_req.err_msg') }}</p>
              </div>
                
        @endswitch
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script>
  $('#mentoring-request-form').validate({
      rules: {
        reqposition: {
          required: true
        },
        reqmotivation: {
          required: true
        }
      },
      messages: {
        reqposition: {
          required: "{{__('app/atc/atc_training_center_req.required_pos') }}"
        },
        reqmotivation: {
          required: "{{__('app/atc/atc_training_center_req.required_motiv') }}"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
</script>
@endsection