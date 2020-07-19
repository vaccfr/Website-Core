<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('app.index', app()->getLocale()) }}" class="brand-link">
    <img src="{{ asset('media/img/logo.png') }}"
         alt="VFLogo"
         class="brand-image"
         style="opacity: .9">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {{-- Top Section of the menu --}}
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link @if (Route::is('app.index')) active @endif">
            <i class="nav-icon fa fa-home"></i>
            <p>{{__('app_menus.home')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fa fa-comments"></i>
            <p>{{__('app_menus.forum')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fa fa-bullhorn"></i>
            <p>{{ __('app_menus.events') }}</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-info"></i>
            <p>
              {{__('app_menus.general')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.staff_org')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.statutes')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.policies')}}</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- ATC Section of the menu --}}
        @if (strpos(Auth::user()->account_type, 'ATC') !== False)
        <li class="nav-header">{{__('app_menus.atc_header')}}</li>
        <li class="nav-item has-treeview @if (str_contains(url()->current(), '/app/atc/book')) menu-open @endif">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-headphones"></i>
            <p>
              {{__('app_menus.atc_bookings')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.atc_all_bookings')}}</p>
              </a>
            </li>
            @if (Auth::user()->isApprovedATC() == true)
            <li class="nav-item">
              <a href="{{ route('app.atc.mybookings', app()->getLocale()) }}" class="nav-link @if (Route::is('app.atc.mybookings')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.atc_my_bookings')}}</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fa fa-graduation-cap"></i>
            <p>Training Center</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.atc.loas', app()->getLocale()) }}" class="nav-link @if (Route::is('app.atc.loas')) active @endif">
            <i class="nav-icon fas fa-sticky-note"></i>
            <p>{{__('app_menus.loas')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>{{__('app_menus.atc_ressources')}}</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('app.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fas fa-download"></i>
            <p>{{__('app_menus.atc_dl')}}</p>
          </a>
        </li>
        @endif

        {{-- Pilot Section of the menu --}}
        @if (strpos(Auth::user()->account_type, 'Pilot') !== False)
        <li class="nav-header">{{__('app_menus.pilots_header')}}</li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>
              {{__('app_menus.pilots_bookings')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.pilots_all_bookings')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('app_menus.pilots_my_bookings')}}</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        {{-- Staff section --}}
        @if (Auth::user()->is_staff == true)
          <li class="nav-header">{{__('app_menus.staff_header')}}</li>
          @if (Auth::user()->isAdmin() == true)
            <li class="nav-item">
              <a href="{{ route('app.staff.admin', app()->getLocale()) }}" class="nav-link @if (Route::is('app.staff.admin')) active @endif">
                <i class="nav-icon fa fa-home"></i>
                <p>Admin</p>
              </a>
            </li>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                {{__('app_menus.staff_atc_mentoring')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('app_menus.staff_atc_mentoring_overview')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('app_menus.staff_atc_mentoring_my_students')}}</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                {{__('app_menus.staff_pil_ment')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('app_menus.staff_pil_ment_overview')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('app_menus.staff_pil_ment_my_students')}}</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>