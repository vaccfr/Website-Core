<!-- Navigation -->
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark navbar-custom">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landingpage.home', app()->getLocale()) }}"
      ><img
        style="height: 30px; width: auto;"
        id="vatfrancelogo"
        src="{{ asset('media/img/VATFrance.png') }}"
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
            <a class="dropdown-item" href="{{ route('app.general.stafforg', app()->getLocale()) }}">Staff vACC</a>
            <a href="{{ route('discord.invite') }}" target="_blank" class="dropdown-item">Discord</a>
            <a href="{{ route('redirect.library') }}" target="_blank" class="dropdown-item">Library</a>
            <a class="dropdown-item" href="{{ route('landingpage.home.policies', app()->getLocale()) }}">{{__('lp/lp_menu.st_and_pol')}}</a>
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
            <a class="dropdown-item" href="{{ route('landingpage.pilot.charts', app()->getLocale()) }}">{{__('lp/lp_menu.charts')}}</a>
            <a class="dropdown-item" href="{{ route('landingpage.pilot.training', app()->getLocale()) }}">{{__('lp/lp_menu.pilot_tr')}}</a>
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
            <a class="dropdown-item" href="{{ route('landingpage.atc.training', app()->getLocale()) }}">{{__('lp/lp_menu.atc_tr')}}</a>
            <a class="dropdown-item" href="{{ route('landingpage.atc.visiting', app()->getLocale()) }}">{{__('lp/lp_menu.vis_contrl')}}</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('landingpage.home.feedback', app()->getLocale()) }}">{{__('lp/lp_menu.feedback')}}</a>
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
            Contact
          </a>
          <div
            class="dropdown-menu animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a href="{{ route('discord.invite') }}" target="_blank" class="dropdown-item">Discord</a>
            <a class="dropdown-item" href="{{ route('landingpage.home.contact', app()->getLocale()) }}">{{__('lp/lp_menu.contact_us')}}</a>
            <a class="dropdown-item" href="{{ route('landingpage.home.reqatc', app()->getLocale()) }}">{{__('lp/lp_menu.req_atc')}}</a>
          </div>
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
            <a href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" class="nav-link">
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
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">
            <span id="utc_time">--:--:--</span> UTC
          </a>
        </li>
        <script>
          // Local and UTC time scripts
          function startTime() {
            var today = new Date();
            var uh = today.getUTCHours();
            var um = today.getUTCMinutes();
            var us = today.getUTCSeconds();
            um = checkTime(um);
            us = checkTime(us);
            document.getElementById('utc_time').innerHTML = uh + ":" + um + ":" + us;
            var t = setTimeout(startTime, 500);
          };
          function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
          };
        </script>
      </ul>
    </div>
  </div>
</nav>