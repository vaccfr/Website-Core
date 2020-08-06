<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} | @yield('page-title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="VatFrance is the Official French Division of the VATSIM Online Virtual Flight Simulation Network. Come check us out!" />
  <meta name="keywords" content="vatsim vatfrance france online flight simulation fsx p3d vateud vateur virtual atc air traffic control euroscope" />
  <meta name="author" content="Peter Paré, Reda Khermach & Corentin Zerbib - VATFRANCE" />
  <meta content="{{ asset('media/img/logo_large.png') }}" property="og:image" />
  <meta content="VatFrance - French Division of VATSIM" property="twitter:title" />
  <meta content="VatFrance is the Official French Division of the VATSIM Online Virtual Flight Simulation Network. Come check us out!" property="twitter:description" />
  <meta content="VatFrance - French Division of VATSIM" property="og:title" />
  <meta content="VatFrance is the Official French Division of the VATSIM Online Virtual Flight Simulation Network. Come check us out!" property="og:description" />
  <link rel="icon" type="image/png" href="{{ asset('media/img/new_favicon.png') }}" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('dashboard/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dashboard/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- flag-icon-css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
  <link href="{{ asset('css/cookie-consent.css') }}" rel="stylesheet" />
  <style type="text/css">
  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  ::-webkit-scrollbar-button {
    width: 0px;
    height: 0px;
  }
  ::-webkit-scrollbar-thumb {
    background: #343a40;
    border: 0px none #ffffff;
    border-radius: 0px;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #444a50;
  }
  ::-webkit-scrollbar-thumb:active {
    background: #000000;
  }
  ::-webkit-scrollbar-track {
    background: #c2c7d0;
    border: 0px none #ffffff;
    border-radius: 0px;
  }
  ::-webkit-scrollbar-track:active {
    background: #333333;
  }
  ::-webkit-scrollbar-corner {
    background: transparent;
  }
  </style>
</head>
<body class="hold-transition sidebar-mini @if (Auth::user()->sidenavCollapsed() == true) sidebar-collapse @endif" onload="startTime()">
<!-- Site wrapper -->
<div class="wrapper">
  
  @include('components.app.topbar')

  @include('components.app.sidenav')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    @yield('page-header')

    <!-- Main content -->
    <section class="content">

      @yield('page-content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('components.app.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dashboard/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dashboard/adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
</script>
@if (session()->has("toast-success"))
  <script lang="javascript">
    Toast.fire({
      icon: 'success',
      title: '{{ session("toast-success") }}'
    });
  </script>
@endif

@if (session()->has("toast-error"))
  <script lang="javascript">
    Toast.fire({
      icon: 'error',
      title: '{{ session("toast-error") }}'
    });
  </script>
@endif

@if (session()->has("toast-info"))
  <script lang="javascript">
    Toast.fire({
      icon: 'info',
      title: '{{ session("toast-info") }}'
    });
  </script>
@endif

@if (session()->has("pop-success"))
  <script lang="javascript">
    Swal.fire(
      'Success!',
      "{{ session('pop-success') }}",
      'success'
    )
  </script>
@endif

@if (session()->has("pop-info"))
  <script lang="javascript">
    Swal.fire(
      'Information',
      "{{ session('pop-info') }}",
      'info'
    )
  </script>
@endif

@if (session()->has("pop-error"))
  <script lang="javascript">
    Swal.fire(
      'Error!',
      "{{ session('pop-error') }}",
      'error'
    )
  </script>
@endif
@include('cookieConsent::index')

@if (Auth::user()->login_alert == true)
<script lang="javascript">
  Swal.fire({
    title: 'Bienvenue sur le nouveau site!',
    text: 'Pour votre première connection, veuillez jeter un coup d\'oeil à vos réglages utilisateur!',
    showCancelButton: false,
    showConfirmButton: true,
    confirmButtonText: 'Voir mes réglages'
  }).then((result) => {
    if (result.value) {
      window.location.href="{{ route('app.user.settings', app()->getLocale()) }}"
    }
  })
</script>
@endif
</body>
</html>
