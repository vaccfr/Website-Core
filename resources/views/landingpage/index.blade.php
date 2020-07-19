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
      @if (Auth::check())
      <a href="{{ route('app.index', app()->getLocale()) }}" class="btn btn-xl btn-pill btn-primary px-7 mt-4"
        >{{__('lp_menu.dashboard')}}</a
      >
      @else
      <a href="#" class="btn btn-xl btn-pill btn-primary px-7 mt-4"
        >{{__('lp_titles.join_us')}}!</a
      >
      @endif
    </div>
  </div>
</header>
@endsection

@section('page-content')
  <!-- Page Content -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-sm">
        <h2 class="font-weight-medium">{{__('lp_titles.welcome')}}!</h2>
        <p class="mt-4">
          Soyez les bienvenus chez Vatfrance ! Nous avons le privilège d'être accueillis par Vatsim.
          Notre but est de vous initier au contrôle aérien. Si vous êtes pilotes, vous apprendrez la phraséologie,
          qui vous permettra de voler dans un espace contrôlé.
          Nous ne sommes qu'une petite équipe constituée de passionnés de l'aviation.
          Au plaisir de vous rencontrer.
        </p>
        <p class="text-right">
          Patrick Fuchez <br />
          {{__('lp_titles.vacc_director')}}
        </p>
      </div>
      <div class="col-sm">
        <h2 class="font-weight-medium">{{__('lp_titles.atc_bookings')}}</h2>
        <div class="card text-center mt-4">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#atc-tab-1" data-toggle="tab">{{ $day0 }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#atc-tab-2" data-toggle="tab">{{ $day1 }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#atc-tab-3" data-toggle="tab">{{ $day2 }}</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" role="tabpanel" id="atc-tab-1">
                @if (count($book0) == 0)
                  No bookings today
                @else
                <table class="table">
                  <thead class="thead">
                    <tr>
                      <th scope="col">{{__('lp_atcbookings.position')}}</th>
                      <th scope="col">{{__('lp_atcbookings.name')}}</th>
                      <th scope="col">{{__('lp_atcbookings.hours')}}</th>
                      <th scope="col">{{__('lp_atcbookings.rating')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($book0 as $b)
                    <th scope="row">{{$b['position']}}</th>
                    <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                    <td>{{$b['time']}}</td>
                    <td>{{$b['user']['atc_rating_short']}}</td>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <div class="tab-pane" role="tabpanel" id="atc-tab-2">
                @if (count($book1) == 0)
                  No bookings tomorrow
                @else
                <table class="table">
                  <thead class="thead">
                    <tr>
                      <th scope="col">{{__('lp_atcbookings.position')}}</th>
                      <th scope="col">{{__('lp_atcbookings.name')}}</th>
                      <th scope="col">{{__('lp_atcbookings.hours')}}</th>
                      <th scope="col">{{__('lp_atcbookings.rating')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($book1 as $b)
                    <th scope="row">{{$b['position']}}</th>
                    <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                    <td>{{$b['time']}}</td>
                    <td>{{$b['user']['atc_rating_short']}}</td>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
              <div class="tab-pane" role="tabpanel" id="atc-tab-3">
                @if (count($book2) == 0)
                  No bookings after tomorrow
                @else
                <table class="table">
                  <thead class="thead">
                    <tr>
                      <th scope="col">{{__('lp_atcbookings.position')}}</th>
                      <th scope="col">{{__('lp_atcbookings.name')}}</th>
                      <th scope="col">{{__('lp_atcbookings.hours')}}</th>
                      <th scope="col">{{__('lp_atcbookings.rating')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($book2 as $b)
                    <th scope="row">{{$b['position']}}</th>
                    <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                    <td>{{$b['time']}}</td>
                    <td>{{$b['user']['atc_rating_short']}}</td>
                    @endforeach
                  </tbody>
                </table>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection