@extends('layouts.landing')

@section('page-title')
  Contact
@endsection

@section('page-masthead')
<header class="masthead-50">
  <div class="container h-100 bg-overlay justify-content-center">
    <div class="row h-75 align-items-center">
      <div class="col-12 text-center">
        <h1 class="masthead-heading">Contact us</h1>
      </div>
    </div>
  </div>
</header>
@endsection

@section('page-content')
<div class="container">
  <div class="row">
    <div class="col-xl-8 offset-xl-2 py-5">
      <form
        id="contact-form"
        method="post"
        action="contact.php"
        role="form"
      >
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
                  placeholder="Please enter your name *"
                  required="required"
                  data-error="Name is required."
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
                  placeholder="Please enter your VATSIM CID *"
                  required="required"
                  data-error="CID is required."
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
                  placeholder="Please enter your email *"
                  required="required"
                  data-error="Valid email is required."
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

<script src="contact.js"></script>
@endsection

