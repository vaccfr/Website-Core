@extends('layouts.landing')

@section('page-title')
  Contact
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
    <h1>Contact us</h1>
  </div>
</section>
@endsection

@section('page-content')
@if (!Auth::check())
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 py-3" align="center">
      <h4>
        {!!__('lp/lp_menu.warning_contact')!!}
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
        action="{{ route('landingpage.home.contact.submit', app()->getLocale()) }}"
        role="form"
      >
      @csrf
        <div class="messages"></div>

        <div class="controls">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_name">Name *</label>
                <input
                  id="form_name"
                  type="text"
                  name="name"
                  class="form-control"
                  value="{{ auth()->user()->fname}} {{ auth()->user()->lname}}"
                  required="required"
                  data-error="Name is required."
                  readonly
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_cid">CID *</label>
                <input
                  id="form_cid"
                  type="text"
                  name="cid"
                  class="form-control"
                  value="{{ auth()->user()->vatsim_id}}"
                  required="required"
                  data-error="CID is required."
                  readonly
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="form_email">Email *</label>
                <input
                  id="form_email"
                  type="email"
                  name="email"
                  class="form-control"
                  value="{{ auth()->user()->email}}"
                  required="required"
                  data-error="Valid email is required."
                  readonly
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="form_message">Message *</label>
                <textarea
                  id="form_message"
                  name="message"
                  class="form-control"
                  placeholder="Please enter your message *"
                  rows="4"
                  required="required"
                  data-error="Please, leave us a message."
                ></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-12">
              <input
                type="submit"
                class="btn btn-secondary btn-send"
                value="Send message"
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
  <!-- /.row-->
</div>
<!-- /.container-->  
@endif
@endsection

