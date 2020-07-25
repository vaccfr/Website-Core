<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
    <link href="{{ asset('css/cookie-consent.css') }}" rel="stylesheet" />

    <!-- Custom fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700,800,900"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Space+Moon:100,100i,300,300i,400,400i,700,700i,900,900i"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--VatFrance specific CSS-->
    <link href="css/main.css" rel="stylesheet">

    <!--Jarallax-->
    <script src="https://unpkg.com/jarallax@1/dist/jarallax.min.js"></script>
    <script src="https://unpkg.com/jarallax@1/dist/jarallax-video.min.js"></script>
    <script src="https://unpkg.com/jarallax@1/dist/jarallax-element.min.js"></script>

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
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"
      integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8="
      crossorigin="anonymous"
    ></script>
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
  @include('cookieConsent::index')
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
  </body>
</html>
