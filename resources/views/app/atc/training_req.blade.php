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
          <h1>{{__('app/atc/atc_training_center.header_title', ['FNAME' => Auth::user()->fname])}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Welcome!</h3>
        </div>
        <div class="card-body">
          Welcome to the new ATC Training Center of Vatfrance!<br>
          This area of the site has been specially tailored by ATC mentors
          to make your journey through learning how to become a virtual ATC
          more pleasant and efficient.<br><br>

          With a custom tailored interface and a simple yet inviting design,
          the new Training Center will guide you through your progress.<br><br>
          
          To begin your mentoring, please submit your application on the right.
        </div>
        <div class="card-footer">
          <i style="font-size: 14px">Response times may vary based on mentor availabilities. Please be patient.</i>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Request ATC Mentoring</h3>
        </div>
        @switch($show)
            @case("NORMAL")
              <form action="{{ route('app.atc.training.mentoringRequest', app()->getLocale()) }}" method="post" id="mentoring-request-form" name="mentoring-request-form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="reqposition">Choose your position</label>
                    <select class="form-control" name="reqposition" id="reqposition">
                      <option value="" disabled selected>Select...</option>
                      @foreach ($platforms as $p)
                        @if (!in_array($p['icao'], $excl))
                        <option value="{{ $p['icao'] }}">{{ $p['icao'] }} ({{ $p['city'] }} {{ $p['airport'] }})</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="reqmotivation">Your motivation</label>
                    <textarea class="form-control" rows="5" name="reqmotivation" id="reqmotivation" style="resize: none;" placeholder="Start typing..."></textarea>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
              @break
            
            @case("NOREGION")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">You must be affiliated to the French Region with your Vatsim Account before you can request mentoring.</p>
              </div>
              @break
            @case("DONE")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">You have already requested training. Please wait for a response</p>
              </div>
              @break
            
            @case("CLOSED")
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">The Training Center is currently closed.</p>
              </div>
              @break
            @default
              <div class="card-body">
                <p class="text-danger" style="font-weight: bolder;">An error occured.</p>
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
          required: "Please choose a position"
        },
        reqmotivation: {
          required: "Please explain your motivation"
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