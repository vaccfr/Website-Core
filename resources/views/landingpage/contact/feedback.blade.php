@extends('layouts.landing')

@section('page-title')
  Feedback
@endsection

{{-- @section('page-masthead')
<header class="masthead-50">
  <div class="container h-100 bg-overlay justify-content-center">
    <div class="row h-75 align-items-center">
      <div class="col-12 text-center">
        <h1 class="masthead-heading">Contact us</h1>
      </div>
    </div>
  </div>
</header>
@endsection --}}

@section('page-masthead')
<section class="intro">
  <div class="container_ATC">
    <h1>{!!__('lp/lp_menu.title_feedback')!!} &darr;</h1>
    <h6>{!!__('lp/lp_menu.subhead_feedback')!!}</h6>
  </div>
</section>
@endsection

@section('page-content')
@if (!Auth::check())
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 py-3" align="center">
      <h4>
        {!!__('lp/lp_menu.warning_feedback')!!}
      </h4>
      <br>
      <form action="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'true']) }}" method="get">
        @csrf
        <input
          type="submit"
          class="btn btn-secondary btn-send"
          value="{!!__('lp/lp_menu.login_w_sso')!!}"
        />
      </form>
    </div>
  </div>
</div>
@else
<div class="container">
<div class="row">
  <div class="col-xl-8 offset-xl-2 py-5">
    <form
      id="contact-form"
      method="post"
      action="{{ route('landingpage.home.feedback.submit', app()->getLocale()) }}"
      role="form"
    >
    @csrf
      <div class="messages"></div>

      <div class="controls">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="form_name">Name</label>
              <input
                id="form_name"
                type="text"
                name="name"
                class="form-control"
                value="{{ auth()->user()->fname}} {{ auth()->user()->lname}}"
                required="required"
                readonly
              />
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="form_cid">CID</label>
              <input
                id="form_cid"
                type="number"
                name="cid"
                class="form-control"
                value="{{ auth()->user()->vatsim_id}}"
                required="required"
                readonly
              />
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="form_email">Controller CID *</label>
                <input
                  id="controller_cid"
                  type="number"
                  name="controller_cid"
                  class="form-control"
                  required="required"
                  @if ($cidIndicated == true)
                  readonly
                  value="{{$cidValue}}"
                  @else
                  placeholder="E.g.: 1267123"
                  @endif
                />
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
                <label for="form_email">Controller Position *</label>
                <input
                  id="position"
                  type="text"
                  name="position"
                  class="form-control"
                  required="required"
                  placeholder="E.g.: LFPG_APP"
                />
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="form_date"> Date (dd/mm/yyyy) *</label>
              <input
                id="dateSelect"
                type="date"
                name="date"
                class="form-control"
                placeholder="Please enter the occurence date *"
                required="required"
                data-error="Occurence date is required."
                max="2100-01-01"
              />
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="form_date"> Time UTC (HH:MM) *</label>
              <input
                id="dateSelect"
                type="time"
                name="time"
                class="form-control"
                placeholder="00:00"
                required="required"
                data-error="Occurence time is required."
              />
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>

        <div class="row">
          </div>
          <div class="col-md-16">
            <div class="form-group">
              <label for="form_message">Message *</label>
              <textarea
                id="form_message"
                name="message"
                class="form-control"
                placeholder="Buy this controller a &#129360;"
                {{-- placeholder="Please give this ATCO a raise." --}}
                rows="4"
                required="required"
                data-error="Please, leave us a message."
              ></textarea>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="col-md-16">
            <input
              type="submit"
              class="btn btn-secondary btn-send"
              value="Submit feedback"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p class="text-muted">
              <strong>*</strong> These fields are required.
            </p>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- /.8 -->
</div>
<!-- /.container-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = yyyy + '-' + mm + '-' + dd ;
  $('#dateSelect').attr('max', today);
</script>
@if ($cidIndicatedFlash == true)
  <script lang="javascript">
    Swal.fire(
      'Feedback',
      "You are about to provide feedback for {{$cidUser['fname']}} {{$cidUser['lname']}} (CID: {{$cidUser['vatsim_id']}})",
      'info'
    )
  </script>
@endif

@endif
@endsection

