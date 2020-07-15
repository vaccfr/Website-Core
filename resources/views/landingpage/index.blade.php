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
          Lorem ipsum dolor sit amet, consectetur adipisicing elit.
          Repellendus ab nulla dolorum autem nisi officiis blanditiis
          voluptatem hic, assumenda aspernatur facere ipsam nemo ratione
          cumque magnam enim fugiat reprehenderit expedita, Lorem ipsum
          dolor sit amet, consectetur adipisicing elit. Repellendus ab nulla
          dolorum autem nisi officiis blanditiis voluptatem hic, assumenda
          aspernatur facere ipsam nemo ratione cumque magnam enim fugiat
          reprehenderit expedita. Lorem ipsum dolor sit amet, consectetur
          adipisicing elit. Repellendus ab nulla dolorum autem nisi officiis
          blanditiis voluptatem hic, assumenda aspernatur facere ipsam nemo
          ratione cumque magnam enim fugiat reprehenderit expedita
        </p>
        <p class="text-right">
          John Doe <br />
          {{__('lp_titles.vacc_director')}}
        </p>
      </div>
      <div class="col-sm">
        <h2 class="font-weight-medium">{{__('lp_titles.atc_bookings')}}</h2>
        <div class="card text-center mt-4">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#atc-tab-1" data-toggle="tab">Mon. 01/01</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#atc-tab-2" data-toggle="tab">Tue. 01/02</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#atc-tab-3" data-toggle="tab">Wed. 01/03</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" role="tabpanel" id="atc-tab-1">
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
                    <tr>
                      <th scope="row">LFLL_TWR</th>
                      <td>Jacob Doe (1458754)</td>
                      <td>09:00z - 15:00z</td>
                      <td>S1</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" role="tabpanel" id="atc-tab-2">
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
                    <tr>
                      <th scope="row">LSGG_APP</th>
                      <td>Jacob Doe (1458754)</td>
                      <td>09:00z - 15:00z</td>
                      <td>S1</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" role="tabpanel" id="atc-tab-3">
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
                    <tr>
                      <th scope="row">LSGG_APP</th>
                      <td>Jacob Doe (1458754)</td>
                      <td>09:00z - 15:00z</td>
                      <td>S1</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection