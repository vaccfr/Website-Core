<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landingpage.home', app()->getLocale()) }}"
      ><img
        style="height: 2.5rem; width: auto;"
        id="vatfrancelogo"
        src="{{ asset('media/img/logo_large.png') }}"
        alt=""
    /></a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarResponsive"
      aria-controls="navbarResponsive"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="{{ route('landingpage.home', app()->getLocale()) }}"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{__('lp/lp_menu.home')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Staff </a>
            <a class="dropdown-item" href="{{ route('landingpage.home.policies', app()->getLocale()) }}">Statutes and Policies</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{__('lp/lp_menu.pilots')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Charts</a>
            <a class="dropdown-item" href="#">Pilot training</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{__('lp/lp_menu.atc')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">ATC training</a>
            <a class="dropdown-item" href="#">Bookings</a>
            <a class="dropdown-item" href="#">Visiting Controllers</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{__('lp/lp_menu.events')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Upcoming Events</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">{{__('lp/lp_menu.feedback')}}</a>
        </li>
        @if (Auth::check())
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fas fa-user text-white d-mobile-none"></i>
              <span class="d-tablet-none">{{ Auth::user()->fname }}</span>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right animate slideIn"
              aria-labelledby="navbarDropdownMenuLink"
            >
              <a class="dropdown-item" href="{{ route('app.index', app()->getLocale()) }}">{{__('lp/lp_menu.dashboard')}}</a>
              <a class="dropdown-item" href="{{ route('auth.logout', app()->getLocale()) }}">{{__('lp/lp_menu.logout')}}</a>
            </div>
          </li>
        @else
          <li class="nav-item">
            <a href="{{ route('auth.login', app()->getLocale()) }}" class="nav-link">
              <i class="fas fa-user text-white d-mobile-none"></i>
              <span class="d-tablet-none">{{__('lp/lp_menu.login')}}</span>
            </a>
          </li>
        @endif
        <li class="nav-item dropright">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img src="{{ asset('media/img/'.app()->getLocale().'-flag.png') }}" alt="{{ strtoupper(app()->getLocale()) }}" style="height: 24px">
          </a>
          <div
            class="dropdown-menu animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            @foreach (config('app.available_locales') as $locale)
            <a
              class="dropdown-item"
              href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $locale) }}"
              @if (app()->getLocale() == $locale) style="font-weight: bold;" @endif>
              <img src="{{ asset('media/img/'.$locale.'-flag.png') }}" alt="{{ strtoupper($locale) }}" style="height: 24px"> {{ strtoupper($locale) }}
            </a>
            @endforeach
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>