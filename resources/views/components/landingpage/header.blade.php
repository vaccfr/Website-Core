<!-- navbar -->
<header class="header">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('landingpage.home', app()->getLocale()) }}">
        <img class="logo" src="{{ asset('media/img/logo.png') }}" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link nav-elem" href="{{ route('landingpage.home', app()->getLocale()) }}">{{__('lp_menu.home')}}<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{__('lp_menu.atc')}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('landingpage.atc.training', app()->getLocale()) }}">{{__('lp_menu.training_atc')}}</a>
              <a class="dropdown-item" href="{{ route('landingpage.atc.request', app()->getLocale()) }}">{{__('lp_menu.request_atc')}}</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{__('lp_menu.pilots')}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('landingpage.pilot.training', app()->getLocale()) }}">{{__('lp_menu.training_pilots')}}</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-elem" href="{{ route('landingpage.home', app()->getLocale()) }}#aboutus">{{__('lp_menu.aboutus')}}</a>
          </li>
          @if (Auth::check())
            <a class="nav-link nav-elem" href="{{ route('auth.logout') }}">{{__('lp_menu.logout')}}</a>
            <a class="nav-link nav-elem" href="{{ route('app.index', app()->getLocale()) }}">{{__('lp_menu.homebtn', ['fname' => Auth::user()->fname])}}</a>
          @else
            <a class="nav-link nav-elem" href="{{ route('auth.login') }}">{{__('lp_menu.login')}}</a>
          @endif
        </ul>
      </div>
    </div>
  </nav>
</header>