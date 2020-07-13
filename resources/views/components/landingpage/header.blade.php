<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landingpage.home', app()->getLocale()) }}"
      ><img
        style="height: 40px; width: auto;"
        id="vatfrancelogo"
        src="{{ asset('media/img/lp/logo.png') }}"
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
            {{__('lp_menu.home')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
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
            {{__('lp_menu.pilots')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
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
            {{__('lp_menu.atc')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
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
            {{__('lp_menu.events')}}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Action</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">{{__('lp_menu.feedback')}}</a>
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
                {{__('lp_menu.home_title', ['fname' => Auth::user()->fname])}}
              </a>
              <div
                class="dropdown-menu dropdown-menu-right animate slideIn"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <a class="dropdown-item" href="{{ route('app.index', app()->getLocale()) }}">{{__('lp_menu.homebtn')}}</a>
                <a class="dropdown-item" href="{{ route('auth.logout', app()->getLocale()) }}">{{__('lp_menu.logout')}}</a>
              </div>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route('auth.login', app()->getLocale()) }}" class="nav-link">
                <i class="fas fa-user text-white d-mobile-none"></i>
                <span class="d-tablet-none">{{__('lp_menu.login')}}</span>
              </a>
            </li>
          @endif
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{ strtoupper(app()->getLocale()) }}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right animate slideIn"
            aria-labelledby="navbarDropdownMenuLink"
          >
            @foreach (config('app.available_locales') as $locale)
            <a
              class="dropdown-item"
              href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $locale) }}"
              @if (app()->getLocale() == $locale) style="font-weight: bold;" @endif>
              {{ strtoupper($locale) }}
            </a>
            @endforeach
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>