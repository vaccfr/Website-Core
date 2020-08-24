@extends('layouts.landing')

@section('page-title')
  Request ATC
@endsection

{{-- @section('page-masthead')
<header class="masthead-50">
  <div class="container h-100 bg-overlay justify-content-center">
    <div class="row h-75 align-items-center">
      <div class="col-12 text-center">
        <h1 class="masthead-heading">Request ATC</h1>
        <h5 class="masthead-subheading">
          Need ATC for an event? Tell us about it!
        </h5>
      </div>
    </div>
  </div>
</header>
@endsection --}}

@section('page-masthead')
<section class="intro">
  <div class="container_ATC">
    <h1>Request ATC</h1>
  </div>
</section>
@endsection

@section('page-content')
@if (!Auth::check())
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 py-3" align="center">
      <h4>
        {!!__('lp/lp_menu.warning_reqatc')!!}
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
        action="{{ route('landingpage.home.reqatc.submit', app()->getLocale()) }}"
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
            <div class="col-md-12">
              <div class="form-group">
                <label for="form_email">Email</label>
                <input
                  id="form_email"
                  type="email"
                  name="email"
                  class="form-control"
                  value="{{ auth()->user()->email}}"
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
                <label for="form_eventname">Event Name *</label>
                <input
                  id="form_eventname"
                  type="text"
                  name="event_name"
                  class="form-control"
                  placeholder="Cross the Land! - Eastbound"
                  required="required"
                  data-error="Event Name is required."
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="form_date">Event Date *</label>
                <input
                  id="dateSelect"
                  type="date"
                  name="event_date"
                  class="form-control"
                  placeholder="Please enter the event date *"
                  required="required"
                  data-error="Event date is required."
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_sponsors">Event Sponsors</label>
                <input
                  id="form_sponsors"
                  type="text"
                  name="sponsors"
                  class="form-control"
                  placeholder="VATÉIR, VATAME"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_website">Event Website</label>
                <input
                  id="form_eventwebsite"
                  type="text"
                  name="website"
                  class="form-control"
                  placeholder="ctl.vatsim.net"
                />
              </div>
            </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_dep">Departure Airport and Time *</label>
                <input
                  id="form_dep"
                  type="text"
                  name="dep"
                  class="form-control"
                  placeholder="EIDW 11:00z"
                  required="required"
                  data-error="This field is required."
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="form_arr">Arrival Airport and Time of the Last Arrival *</label>
                <input
                  id="form_arr"
                  type="text"
                  name="arr"
                  class="form-control"
                  placeholder="HECA 20:00z"
                />
                <div class="help-block with-errors"></div>
              </div>
            </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="form_positions">Positions Requested *</label>
                  <input
                    id="form_positions"
                    type="text"
                    name="positions"
                    class="form-control"
                    placeholder="LFFF_CTR, LFEE_CTR, LFMM_CTR"
                    required="required"
                    data-error="This field is required."
                  />
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="form_pilots">Number of Expected Pilots *</label>
                  <input
                    id="form_pilots"
                    type="number"
                    name="pilots"
                    class="form-control"
                    required="required"
                    data-error="This field is required."
                  />
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="form_message">Route *</label>
                <textarea
                  id="form_route"
                  name="route"
                  class="form-control"
                  placeholder="LIFFY Q36 EPOXI L15 HON L10 RINTI UL10 LESDO UL15 BEGAR Q341 RESIA T415 UTAME T292 KAPPO L612 ARA A14 TRL L612 SIT L607 PAXIS A727 OTIKO "
                  rows="4"
                  required="required"
                  data-error="Please, leave us a message."
                ></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="form_message">Message *</label>
                <textarea
                  id="form_message"
                  name="message"
                  class="form-control"
                  placeholder="Please mention which other vACCs have been contacted and responded to the request."
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
                value="Request ATC"
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