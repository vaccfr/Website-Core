@extends('layouts.landing')

@section('pagetitle')
    Home
@endsection

@section('hero')
<!-- vid container -->
<section name="video">
  <div class="vidcontainer">
    <div class="overlay"></div>
      <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
        <source src="{{ asset('media/videos/lpagehome.mp4') }}" type="video/mp4">
      </video>
      <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
          <div id="textabovevid"class="w-100 text-white">
            <h1 class="display-3">Welcome to VatFrance</h1>
            <p id="scdline" class="lead mb-0">French branch of VATSIM network</p>
            <button id="btnjoin" type="button" class="btn btn-primary-spacing btn-lg">Join us</button>
          </div>
        </div>
    </div>
  </div>
</section>
@endsection

@section('aboutus')
<section name="about">
  <div class="aboutus">
    <h1>About us</h1>
    <p id="welcomep">Welcome to VatFrance! The french place for virtual pilots and ATC members of the VATSIM Network !</p>
    <p>Our objective is to provide ATC services, organizing events, train controllers and pilots in the French vACC.</p>
    <p id="thirdp">Want to join us as a visitor member ? Do not hesitate and join our Teamspeak server here</p>
    <p>Our watchword: seriousness and good mood/humour. We French are waiting for you!</p>
    <p id="dataptc"><a class="dphp" href="{{ route('policy.privacy') }}" target="_blank">Data Protection and Handling Policy</a></p>
  </div>
</section>
@endsection

@section('stats')
<section name="statistics">
  <div class="stats">
    <h1>Statistics</h1>
    <h3 class="desc">VatFrance in figures</h3>

      <div class="row">
        <!--Grid column-->
        <div class="col-lg-3 col-md-12 mb-4">
          <div class="text-center">
            <h2 class="h1 mb-0">465</h2>
            <p>Pilots Inbound or Outbound of French Airports</p>
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="text-center">
            <h2 class="h1 mb-0">4</h2>
            <p>Online ATC</p>
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="text-center">
            <h2 class="h1 mb-0">LFPG</h2>
            <p>Busiest airport at the moment</p>
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="text-center">
            <h2 class="h1 mb-0">LFLL</h2>
            <p>Busiest airport at the moment (with ATC online)</p>
          </div>
        </div>
        <!--Grid column-->
    </div>
  <!--Grid row-->
  </div>
</section>
@endsection

@section('upcoming')
<section name="upcoming">
  <div class="blog-home2 py-5">
    <div class="container">
      <!-- Row  -->
      <div class="row justify-content-center">
        <!-- Column -->
        <div class="col-md-8 text-center">
          <h3 id="titlesection" class="my-3">Upcoming Events</h3>
          <h3 class="subtitle">You will find here all the upcoming events within the French division of Vatsim! This is the perfect opportunity to liven up the blue white red sky !</h3>
        </div>
        <!-- Column -->
        <!-- Column -->
      </div>
      <div class="row mt-4">
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/occitanie.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">July<span class="d-block">07</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">Venez atterrir en Occitanie !</a></h5>
            <p class="mt-3">Come and fly to Occitania ! LFMT, LFCR, LFBO and many more platforms will be staffed just for you</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/friday.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">July<span class="d-block">10</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">Friday Online Day</a></h5>
            <p class="mt-3">Friday French Online Day ! Come to France to have the chance to see many french positions staffed this day !</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/shuttle.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">July<span class="d-block">16</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">Shuttle Bordeaux-Lyon (LFBD-LFLL)</a></h5>
            <p class="mt-3">Come and fly from/to Bordeaux or Lyon. Both platforms including centers will be staffed for you !</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/citylink.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">July<span class="d-block">17</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">Citylink LFMN-LIRN</a></h5>
            <p class="mt-3">Citylink between Nice And Naples. Enjoy full coverage between these two airports today!</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/yet2come.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">Aug<span class="d-block">10</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">To come</a></h5>
            <p class="mt-3">The best is yet to come!</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-4 on-hover">
          <div class="card border-0 mb-4">
            <a href="#"><img class="card-img-top" src="{{ asset('media/img/events/yet2come.jpg') }}" alt="wrappixel kit"></a>
            <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">Aug<span class="d-block">16</span></div>
            <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">To come</a></h5>
            <p class="mt-3">The best is yet to come!</p>
            <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection