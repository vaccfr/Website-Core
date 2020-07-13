@extends('layouts.landing')

@section('page-title')
  Home
@endsection

@section('page-masthead')
<header class="masthead text-center text-white">
  <div class="masthead-content">
    <div class="container bg-overlay">
      <h1 class="masthead-heading mb-2 mt-5">{{__('lp_titles.welcome_to_vatfrance')}}@if (Auth::check()), {{ Auth::user()->fname }}@endif!</h1>
      <h2 class="masthead-subheading mb-2">{{__('lp_titles.french_branch')}}</h2>
      <a href="#" class="btn btn-xl btn-pill btn-primary px-7 mt-4"
        >@if (!Auth::check()) {{__('lp_titles.join_us')}}! @else {{__('lp_menu.dashboard')}} @endif</a
      >
    </div>
  </div>
</header>
@endsection

@section('page-content')
  <!-- Page Content -->
<section class="py-5">
  <div class="container">
    <h2 class="font-weight-medium">{{__('lp_titles.welcome')}}!</h2>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus
      ab nulla dolorum autem nisi officiis blanditiis voluptatem hic,
      assumenda aspernatur facere ipsam nemo ratione cumque magnam enim
      fugiat reprehenderit expedita, Lorem ipsum dolor sit amet, consectetur
      adipisicing elit. Repellendus ab nulla dolorum autem nisi officiis
      blanditiis voluptatem hic, assumenda aspernatur facere ipsam nemo
      ratione cumque magnam enim fugiat reprehenderit expedita. Lorem ipsum
      dolor sit amet, consectetur adipisicing elit. Repellendus ab nulla
      dolorum autem nisi officiis blanditiis voluptatem hic, assumenda
      aspernatur facere ipsam nemo ratione cumque magnam enim fugiat
      reprehenderit expedita
    </p>
    <p class="text-right">
      John Doe <br />
      {{__('lp_titles.vacc_director')}}
    </p>
  </div>
</section>
@endsection