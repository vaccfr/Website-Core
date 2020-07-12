<!-- navbar -->
<header class="header">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('landingpage.home') }}">
        <img class="logo" src="{{ asset('media/img/logo.png') }}" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link nav-elem" href="{{ route('landingpage.home') }}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Controllers
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('landingpage.atc.training') }}">Training</a>
              <a class="dropdown-item" href="{{ route('landingpage.atc.request') }}">Request ATC</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Pilots
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('landingpage.pilot.training') }}">Training</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-elem" href="{{ route('landingpage.home') }}#aboutus">About us</a>
          </li>
          @if (Auth::check())
            <a class="nav-link nav-elem" href="{{ route('auth.logout') }}">Logout</a>
            <a class="nav-link nav-elem" href="{{ route('app.index') }}">Home - {{ Auth::user()->fname}}</a>
          @else
            <a class="nav-link nav-elem" href="{{ route('auth.login') }}">Login</a>
          @endif
        </ul>
      </div>
    </div>
  </nav>
</header>