@extends('layouts.landing')

@section('page-title')
  Home
@endsection

@section('page-masthead')
<header class="masthead">
  <div>
      <video loop muted autoplay playsinline class="animated_bg__video" src="{{ asset('/media/video/lp/vatfrance_bg.mp4') }}">
          <source src="{{ asset('/media/video/lp/vatfrance_bg.webm') }}" type="video/webm">
          <source src="{{ asset('/media/video/lp/vatfrance_bg.mp4') }}" type="video/mp4">
      </video>
  </div>
  <div class="container-fluid h-100 bg-overlay d-flex align-items-end masthead-container" >
    <div class="row container-fluid no-gutters">
      <div class="col-12">
        <h1 class="masthead-heading">{{__('lp/lp_titles.welcome_to_vatfrance')}}@if (Auth::check()), {{ Auth::user()->fname }}@endif!</h1>
        <h2 class="masthead-subheading">{{__('lp/lp_titles.french_branch')}}</h2>
        @if (Auth::check())
        <a href="{{ route('app.index', app()->getLocale()) }}" 
          class="btn btn-xl btn-pill btn-primary px-7 mt-4">{{__('lp/lp_menu.dashboard')}}</a>
        @else
        <a href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" 
          class="btn btn-xl btn-pill btn-primary px-7 mt-4">{{__('lp/lp_titles.join_us')}}!</a>
        @endif
      </div>
    </div>
  </div>
</header>
@endsection

@section('page-content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<!-- Page Content -->
  <div class="container-fluid py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3 class="font-weight-medium mt-3">{{__('lp/lp_titles.welcome')}}!</h3>
          <p class="mt-4">
            {{__('lp/lp_index.director_text')}}
          </p>
          <p class="text-right">
            Patrick Fuchez <br />
            {{__('lp/lp_titles.vacc_director')}}
          </p>
        </div>
        <div class="col-md-6">
          <h3 class="font-weight-medium mt-3">{{__('lp/lp_titles.atc_bookings')}}</h3>
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
                  {{__('lp/lp_index.nobook_0')}}
                  @else
                  <table class="table table-borderless mt-n3">
                    <thead class="thead">
                      <tr>
                        <th scope="col">{{__('lp/lp_index.position')}}</th>
                        <th scope="col">{{__('lp/lp_index.name')}}</th>
                        <th scope="col">{{__('lp/lp_index.hours')}}</th>
                        <th scope="col">{{__('lp/lp_index.rating')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($book0 as $b)
                      <tr>
                        <th scope="row">{{$b['position']}}</th>
                        <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                        <td>{{$b['time']}}</td>
                        <td>{{$b['user']['atc_rating_short']}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
                
                <div class="tab-pane" role="tabpanel" id="atc-tab-2">
                  @if (count($book1) == 0)
                  {{__('lp/lp_index.nobook_1')}}
                  @else
                  <table class="table">
                    <thead class="thead">
                      <tr>
                        <th scope="col">{{__('lp/lp_index.position')}}</th>
                        <th scope="col">{{__('lp/lp_index.name')}}</th>
                        <th scope="col">{{__('lp/lp_index.hours')}}</th>
                        <th scope="col">{{__('lp/lp_index.rating')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($book1 as $b)
                      <tr>
                        <th scope="row">{{$b['position']}}</th>
                        <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                        <td>{{$b['time']}}</td>
                        <td>{{$b['user']['atc_rating_short']}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
  
                <div class="tab-pane" role="tabpanel" id="atc-tab-3">
                  @if (count($book2) == 0)
                  {{__('lp/lp_index.nobook_2')}}
                  @else
                  <table class="table">
                    <thead class="thead">
                      <tr>
                        <th scope="col">{{__('lp/lp_index.position')}}</th>
                        <th scope="col">{{__('lp/lp_index.name')}}</th>
                        <th scope="col">{{__('lp/lp_index.hours')}}</th>
                        <th scope="col">{{__('lp/lp_index.rating')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($book2 as $b)
                      <tr>
                        <th scope="row">{{$b['position']}}</th>
                        <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                        <td>{{$b['time']}}</td>
                        <td>{{$b['user']['atc_rating_short']}}</td>
                      </tr>
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
  </div>
  <script src="{{ asset('lp/js/data.js') }}" type="text/javascript"></script>
  <div class="container-fluid py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3 class="mt-3 mb-2">Live Map</h3>
          <div class="fluid-container">
            <main role="main">
              <div id="map" style="height: calc(50vh - 120px)" class="mt-2">
                <div style="position: absolute; z-index: 500; background: rgba(0,0,0,0.5); color:white; font-size: 10px; padding: 3px;">Flights: <span>{{$livemap['planeCount']}}</span> / ATC: <span>{{$livemap['atcCount']}}</span></div>
                <!--note for Peter: populate the X's with actual data danke-->
                <script src="{{ asset('lp/js/rotate_marker.js') }}"></script>
                <script>
                  var map = L.map('map', {maxZoom: 19, minZoom: 2, worldCopyJump: true, zoomControl: false, dragging: true, attributionControl: false}).setView([46.7, 2.900333], 5);
                  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}{r}.png', {
                  subdomains: 'abcd',
                  // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                  }).addTo(map);
    
                  var icon = L.icon({
                    iconUrl: "{{ asset('lp/atcmap/plane.png') }}",
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                  });
    
                  var TWR = L.icon({
                    iconUrl: "{{ asset('lp/atcmap/TWR.png') }}",
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                  });
                  
                  function onEachFeature(feature, layer) {
                    // does this feature have a property named popupContent?
                    if (feature.properties && feature.properties.popupContent) {
                        layer.bindTooltip(feature.properties.popupContent, {permanent: true, direction:"center", className: 'label'});
                    }
                  }
                  
                  function polystyle(feature) {
                    return {
                      fillColor: '#3386FF ',
                      weight: 2,
                      opacity: 0.4,
                      color: '#3386FF',  //Outline color
                      fillOpacity: 0.2
                    };
                  }

                  // // This part imports the FIR data
                  // L.geoJSON(FIR, {
                  //   filter: function(feature, layer) {
                  //     return feature.properties.show_on_map;
                  //   },
                  //   onEachFeature: onEachFeature,
                  //   style: polystyle
                  // }).addTo(map);
    
                </script>
                @foreach ($livemap['planes'] as $op)
                  <script>
                    // This part creates a plane icon on the map
                    L.marker(
                      ["{{ $op['lat'] }}", "{{ $op['lon'] }}"], 
                      {rotationAngle: "{{ $op['hdg'] }}", icon: icon} 
                    )
                    .addTo(map)
                    .bindTooltip( 
                      "<div style='font-size: 90%'><strong>{{ $op['callsign'] }}</strong> - " + "{{ $op['dep'] }}" + "/" + "{{ $op['arr'] }}" + "<br>" + "{{ $op['gspd'] }}" + "kts @ " + "{{ $op['alt'] }}" + "ft</div>", 
                      {offset: [10,0], direction: 'right'}
                    );
                  </script>
                @endforeach

                @foreach ($livemap['appr'] as $app)
                  <script>
                    // This part creates an approach position circle on the map
                    L.circle(
                      ["{{ $app['lat'] }}", "{{ $app['lon'] }}"],
                      {
                        radius: 50000,
                        fillColor: '#3386FF ',
                        weight: 2,
                        opacity: 0.7,
                        color: '#3386FF',  //Outline color
                        fillOpacity: 0.2
                      }
                    )
                    .addTo(map)
                    .bindTooltip(
                      "<div style='font-size: 90%'><strong>{{ $app['callsign'] }}</strong>" + "<br>" +  "<center>" + "{{ $app['freq'] }}" +"</center>" + "</div>",
                      {offset: [0,0], direction: 'left'}
                    );
                  </script>
                @endforeach

                @foreach ($livemap['twr'] as $twr)
                  <script>
                    // This part creates a tower object on the map
                    L.marker(
                      ["{{ $twr['lat'] }}", "{{ $twr['lon'] }}"], 
                      {icon: TWR,}
                    )
                    .addTo(map)
                    .bindTooltip(
                      "<div style='font-size: 90%'><strong>{{ $twr['callsign'] }}</strong> " + "<br>" +  "<center>" + "{{ $twr['freq'] }}" +"</center>" + "</div>",
                      {offset: [0,-10], direction: 'top'}
                    ); 
                  </script>
                @endforeach
              </div>
            </main>
            <h6 class="text-muted">Only approach & tower positions and planes for now</h6>
          </div>
        </div>
        <div class="col-md-6">
          <h3 class="mt-3  mb-3">{{__('lp/lp_index.online_atc_title')}}</h3>
          <ul class="list-unstyled ml-0 mt-3 p-0 onlineControllers">
            <li>
              <div class="card shadow-none blue-grey lighten-5 p-3">
                <div class="d-flex flex-row justify-content-between align-items-center mb-1 text-center">
                  @if (count($atconline) == 0)
                    <p style="vertical-align: middle; text-align: center;">{{__('lp/lp_index.noatc')}}</p>
                  @else
                  <table class="table table-borderless">
                    <thead class="thead">
                      <tr>
                        <th scope="col">{{__('lp/lp_index.position')}}</th>
                        <th scope="col">{{__('lp/lp_index.name')}}</th>
                        <th scope="col">{{__('lp/lp_index.livesince')}}</th>
                        <th scope="col">{{__('lp/lp_index.rating')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($atconline as $a)
                        <tr>
                          <th class="position" scope="row">{{$a['callsign']}}</th>
                          <td>{{$a['name']}}</td>
                          <td>{{$a['livesince']}}z</td>
                          <td>{{$a['rating']}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="container-fluid py-4">
          <h3 class="mt-3  mb-3">Announcements and Events</h3>
          <div class="card-columns">
            @foreach ($eventsList as $e)
            <div class="card">
              <img class="card-img-top" src="@if ($e['has_image'] == true)
                  {{config('app.url')}}/{{$e['image_url']}}
              @else
                  {{asset('media/img/placeholders/events_placeholder_noimg.png')}}
              @endif" alt="Card image cap">
              <div class="card-body">
                <h4 class="card-title">{{$e['title']}} <br> {{$e['date']}} | {{$e['start_time']}} - {{$e['end_time']}}</h4>
                <p class="card-text">{{$e['description']}}</p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
