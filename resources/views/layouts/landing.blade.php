<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VatFrance | French vACC | @yield('pagetitle')</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
	<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>

	<body>

    @include('components.landingpage.header')

		@yield('hero')

		@yield('content')

		@yield('aboutus')

		@yield('stats')

		@yield('upcoming')


	<button onclick="topFunction()" id="myBtn" title="Go to top">&#8593;</button>

	@include('components.landingpage.footer')


		<!-- Optional JavaScript -->

		<script src="{{ asset('js/landing.js') }}"></script>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

		<script>
		$(window).scroll(function(){
			$('nav').toggleClass('scrolled', $(this).scrollTop() > 100);
		});
	</script>


	</body>
</html>
