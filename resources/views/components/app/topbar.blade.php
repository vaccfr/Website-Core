<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-black navbar-dark">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">
        <span>
          {{__('app/app_menus.local_time')}}:
        </span>
        <span id="local_time"></span>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">
        <span>
          {{__('app/app_menus.utc_time')}}: 
        </span>
        <span id="utc_time"></span>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">
        <span>
          Online ATC: {{ app(App\Http\Controllers\DataHandlers\VatsimDataController::class)->getOnlineATCCount() }}
        </span>
      </a>
    </li>
    @if (Auth::user()->isAdmin() == true)
    <?php 
    $onlineUsers = app(App\Http\Controllers\DataHandlers\Utilities::class)->onlineUsers();
    ?>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">
        <span>
          Online users: {{$onlineUsers['visitors']}} visitor(s) / {{$onlineUsers['members']}} member(s)
        </span>
      </a>
    </li>
    @endif
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="{{ route('landingpage.home', app()->getLocale()) }}" class="nav-link">
        {{__('app/app_menus.return_lp')}}
      </a>
    </li>
    <li class="nav-item dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link">
        @switch(app()->getLocale())
          @case('fr')
            <i class="flag-icon flag-icon-fr"></i>
            @break
          @case('en')
            <i class="flag-icon flag-icon-gb"></i>
            @break
          @default
                
        @endswitch
      </a>
      <div class="dropdown-menu">
        @foreach (config('app.available_locales') as $locale)
          <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $locale) }}" class="dropdown-item"
            @if (app()->getLocale() == $locale) style="font-weight: bold" @endif>
            @switch($locale)
              @case('fr')
                <i class="flag-icon flag-icon-fr"></i> {{ strtoupper($locale) }}
                @break
              @case('en')
                <i class="flag-icon flag-icon-gb"></i> {{ strtoupper($locale) }}
                @break
              @default
                    
            @endswitch
          </a>
        @endforeach
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i> {{ Auth::user()->fname}} {{ Auth::user()->lname }}
      </a>
      <div class="dropdown-menu">
        <a href="{{ route('app.user.settings', app()->getLocale()) }}" class="dropdown-item">
          {{__('app/app_menus.my_settings')}}
        </a>
        <a href="{{ route('auth.logout', app()->getLocale()) }}" class="dropdown-item">
          {{__('app/app_menus.logout')}}
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<script>
  // Local and UTC time scripts
  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var uh = today.getUTCHours();
    var um = today.getUTCMinutes();
    var us = today.getUTCSeconds();
    m = checkTime(m);
    s = checkTime(s);
    um = checkTime(um);
    us = checkTime(us);
    document.getElementById('local_time').innerHTML = h + ":" + m + ":" + s;
    document.getElementById('utc_time').innerHTML = uh + ":" + um + ":" + us;
    var t = setTimeout(startTime, 500);
  };
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  };
</script>