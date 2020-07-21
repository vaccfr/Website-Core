<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} | @yield('page-title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('media/img/logo_small.png') }}" />

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
</head>
<body class="hold-transition sidebar-mini" onload="startTime()">
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
</body>
</html>
