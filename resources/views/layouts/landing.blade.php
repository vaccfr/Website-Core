<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/png" href="{{ asset('media/img/logo_small.png') }}" />

    <title>{{ config('app.name') }} | @yield('page-title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <script
      src="https://kit.fontawesome.com/995ae00442.js"
      crossorigin="anonymous"
    ></script>
    <script>
      $(document).ready(function () {
        $('.dropdown, .btn-group').hover(function () {
          var dropdownMenu = $(this).children('.dropdown-menu');
          if (dropdownMenu.is(':visible')) {
            dropdownMenu.parent().toggleClass('open');
          }
        });
      });
    </script>

    <!-- Custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700,800,900"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Space+Moon:100,100i,300,300i,400,400i,700,700i,900,900i"
      rel="stylesheet"
    />

    <!-- Custom styles-->
    <link href="{{ asset('lp/css/main.css') }}" rel="stylesheet" />
  </head>

  <body>
    @include('components.landingpage.header')

    @yield('page-masthead')

    @yield('page-content')

		{{-- @include('components.landingpage.footer') --}}

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
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
    
  @if (App::environment() == 'livedev')
  <script lang="javascript">
      Swal.fire(
          'Warning!',
          "This is a development version, not a working website!",
          'info'
      )
  </script>
  @endif
  </body>
</html>
