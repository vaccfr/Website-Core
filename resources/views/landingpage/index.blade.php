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
                  
                  var firDesign = {
                      fillColor: '#3386FF ',
                      weight: 2,
                      opacity: 0.4,
                      color: '#3386FF',  //Outline color
                      fillOpacity: 0.2
                    };

                  // // This part imports the FIR data
                  // L.geoJSON(FIR, {
                  //   filter: function(feature, layer) {
                  //     return feature.properties.show_on_map;
                  //   },
                  //   onEachFeature: onEachFeature,
                  //   style: polystyle
                  // }).addTo(map);
    
                </script>
                <script>
                @foreach ($livemap['planes'] as $op)
                  
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

                @endforeach

                @foreach ($livemap['appr'] as $app)

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

                @endforeach

                @foreach ($livemap['twr'] as $twr)

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
                  
                @endforeach
                </script>

                  <script>
                  @if ($livemap['lfff'])
                    var lfffLatLong = [[50,-0.25],[50.666666666667,1.4666666666667],[51,1.4666666666667],[51.116666666667,2],[51.083333333333,2.55],[50.816666666667,2.6333333333333],[50.8,2.7166666666667],[50.725,2.8166666666667],[50.7,2.9],[50.783333333333,3.1166666666667],[50.678333333333,3.225],[50.53,3.2766666666667],[50.463333333333,3.405],[50.483333333333,3.6166666666667],[50.371944444444,3.66],[50.308333333333,3.71],[50.333333333333,3.7916666666667],[50.316666666667,3.9],[50.35,4.0166666666667],[50.283333333333,4.1722222222222],[50.25,4.1666666666667],[50.15,4.1166666666667],[50.1,4.2],[50.034722222222,4.1488888888889],[50.016666666667,4.125],[49.95,4.1833333333333],[49.933333333333,4.4833333333333],[50,4.6833333333333],[50.097758333333,4.7154027777778],[50.109341666667,4.7331777777778],[50.108333333333,4.7402777777778],[50.118055555556,4.75],[50.137708333333,4.7642805555556],[50.153605555556,4.8075361111111],[50.165761111111,4.8167694444444],[50.167630555556,4.8245444444444],[50.158591666667,4.8376666666667],[50.153916666667,4.8585638888889],[50.156097222222,4.8775222222222],[50.148616666667,4.8814083333333],[50.1402,4.896475],[50.126797222222,4.8702277777778],[50.115277777778,4.8675],[50.088888888889,4.8722222222222],[50.047222222222,4.8388888888889],[49.95,4.8],[49.916666666667,4.8583333333333],[49.783333333333,4.85],[49.783333333333,5],[49.758333333333,5.0666666666667],[49.691666666667,5.175],[49.666666666667,5.3],[49.616666666667,5.3166666666667],[49.608333333333,5.4],[49.5,5.4833333333333],[49.536111111111,5.7583333333333],[49.544694444444,5.8085805555556],[49.505272222222,5.8511027777778],[49.483333333333,5.9583333333333],[49.45,6],[48.95,4.8],[48.25,5.7333333333333],[48.166666666667,5.1666666666667],[47.416666666667,4.3333333333333],[46.5,4.8333333333333],[46.5,3.2666666666667],[46.333333333333,2.9166666666667],[46.75,2.8333333333333],[47.166666666667,2],[47.166666666667,-0.25]];
                    L.polygon(lfffLatLong, firDesign).addTo(map);
                  @endif

                  @if ($livemap['lfrr'])
                    var lfrrLatLong = [[50,-0.25],[46.5,-0.25],[46.5,-1.6333333333333],[43.583333333333,-1.7833333333333],[44.333333333333,-4],[45,-8],[48.833333333333,-8],[50,-2]];
                    L.polygon(lfrrLatLong, firDesign).addTo(map);
                  @endif

                  @if ($livemap['lfee'])
                    var lfeeLatLong = [[48.95,4.8],[49.455555555556,6],[49.466666666667,6.0555555555556],[49.476388888889,6.115],[49.496388888889,6.1844444444444],[49.508333333333,6.225],[49.465833333333,6.3491666666667],[49.466666666667,6.3916666666667],[49.466666666667,6.4],[49.466666666667,6.4666666666667],[49.455555555556,6.5444444444444],[49.432777777778,6.5597222222222],[49.25,6.6833333333333],[49.222777777778,6.7308333333333],[49.162777777778,7.0319444444444],[49.151388888889,7.1588888888889],[49.12,7.3466666666667],[49.080277777778,7.585],[49.050833333333,7.7183333333333],[49.041666666667,7.9166666666667],[49.019444444444,8.0022222222222],[49,8.0666666666667],[48.988055555556,8.1205555555556],[48.974166666667,8.2186111111111],[48.916666666667,8.1541666666667],[48.775,8.0222222222222],[48.716666666667,7.9666666666667],[48.656388888889,7.8730555555556],[48.6,7.8],[48.573055555556,7.8019444444444],[48.566666666667,7.8],[48.520833333333,7.8],[48.506111111111,7.7980555555556],[48.366666666667,7.7333333333333],[48.328055555556,7.7461111111111],[48.321944444444,7.7458333333333],[48.217222222222,7.6616666666667],[48.081388888889,7.5694444444444],[48.0799,7.5694],[48.0774,7.5697],[48.0721,7.5708],[48.0618,7.5731],[48.0576,7.574],[48.0556,7.5743],[48.0536,7.5744],[48.0522,7.5744],[48.0513,7.5743],[48.0505,7.5741],[48.0469,7.5731],[48.0448,7.5724],[48.0427,7.5715],[48.041,7.5709],[48.0386,7.5699],[48.0376,7.5697],[48.0363,7.5695],[48.0353,7.5695],[48.0341,7.5698],[48.0332,7.5701],[48.0325,7.5705],[48.0321,7.5708],[48.02936,7.57291],[48.0249,7.57847],[48.015,7.5905555555556],[48.00405,7.60508],[48.00034,7.60859],[47.99339,7.61447],[47.98589,7.61865],[47.97545,7.622],[47.97279,7.62212],[47.96929,7.62115],[47.96361,7.61735],[47.9582,7.61294],[47.95346,7.60907],[47.94857,7.60336],[47.93825,7.5895],[47.93482,7.5857],[47.9299,7.58265],[47.92693,7.58102],[47.92414,7.58055],[47.92077,7.58101],[47.908333333333,7.5833333333333],[47.89826,7.58253],[47.89495,7.58074],[47.89073,7.57593],[47.88565,7.56359],[47.88241,7.55916],[47.87937,7.55657],[47.87409,7.55545],[47.87053,7.55565],[47.86629,7.55621],[47.86365,7.5573],[47.85781,7.56074],[47.85118,7.56339],[47.844722222222,7.5636111111111],[47.83887,7.56155],[47.83506,7.55924],[47.82293,7.54995],[47.81267,7.54586],[47.80345,7.54108],[47.78691,7.53136],[47.78255,7.53003],[47.7728,7.53017],[47.76604,7.53339],[47.75434,7.53985],[47.74302,7.54615],[47.73946,7.54813],[47.73508,7.54857],[47.72981,7.54763],[47.72232,7.54372],[47.71844,7.53899],[47.70998,7.52412],[47.70282,7.51376],[47.70045,7.51216],[47.69845,7.51171],[47.69675,7.51159],[47.69486,7.51235],[47.689166666667,7.5163888888889],[47.632805555556,7.4995],[47.5775,7.4155555555556],[47.43226,7.3844633333333],[47.371944444444,7.3430555555556],[47.364188888889,7.0431388888889],[47.343022222222,7.0616638888889],[47.292222222222,6.9647222222222],[47.281944444444,6.9408333333333],[47.242815,6.955245],[47.175,6.8458333333333],[47.066666666667,6.6833333333333],[47.0575,6.7086111111111],[47.053333333333,6.7130555555556],[47.051666666667,6.72],[47.044166666667,6.7055555555556],[47.037222222222,6.6955555555556],[47.037777777778,6.6861111111111],[47.034722222222,6.6744444444444],[47.031666666667,6.6688888888889],[47.0275,6.6594444444444],[47.021944444444,6.6533333333333],[47.014166666667,6.6480555555556],[46.973333333333,6.4944444444444],[46.925555555556,6.4325],[46.779444444444,6.4],[46.933333333333,5.8666666666667],[46.683333333333,5.4333333333333],[46.5,5.5858333333333],[46.5,4.8333333333333],[47.416666666667,4.3333333333333],[48.166666666667,5.1666666666667],[48.25,5.7333333333333]];
                    L.polygon(lfeeLatLong, firDesign).addTo(map);
                  @endif

                  @if ($livemap['lfbb'])
                    var lfbbLatLong = [[43.35,-1.7833333333333],[43.583333333333,-1.7833333333333],[46.5,-1.6333333333333],[46.5,-0.25],[47.166666666667,-0.25],[47.166666666667,2],[46.75,2.8333333333333],[46.333333333333,2.9166666666667],[45.7125,3.0044444444444],[44.624722222222,3.0411111111111],[43.714722222222,2.7094444444444],[43.2125,2.7069444444444],[43.258333333333,2.5722222222222],[43,2.275],[42.591111111111,2.7355555555556],[42.416666666667,2.7152777777778]];
                    L.polygon(lfbbLatLong, firDesign).addTo(map);
                  @endif

                  @if ($livemap['lfmm'])
                    var lfmmLatLong = [[46.333333333333,2.9166666666667],[46.5,3.2666666666667],[46.5,6.1083333333333],[46.4167,6.0666694444444],[46.375,6.1583305555556],[46.25,6.125],[46.2,5.9611111111111],[46.1333,5.95],[46.1417,6.125],[46.2583,6.3],[46.3167,6.225],[46.4583,6.5],[46.433333333333,6.8166666666667],[46.3667,6.7666694444444],[46.2917,6.8583305555556],[46.15,6.7916694444444],[46.1333,6.8833305555556],[45.9333,7.05],[45.9,7.0166666666667],[45.833333333333,6.8],[45.716666666667,6.8],[45.65,7],[45.633333333333,6.9833333333333],[45.533333333333,7],[45.333333333333,7.1333333333333],[45.266666666667,7.1333333333333],[45.216666666667,7],[45.133333333333,6.8833333333333],[45.133333333333,6.85],[45.15,6.7666666666667],[45.141666666667,6.7166666666667],[45.1,6.6166666666667],[45.016666666667,6.6666666666667],[45.022222222222,6.75],[44.9,6.75],[44.85,6.9138888888889],[44.866666666667,6.9166666666667],[44.816666666667,7.025],[44.8,7.0055555555556],[44.683333333333,7.0666666666667],[44.7,7],[44.666666666667,6.9583333333333],[44.633333333333,6.9666666666667],[44.55,6.8833333333333],[44.525,6.85],[44.416666666667,6.9333333333333],[44.416666666667,6.8666666666667],[44.358333333333,6.8666666666667],[44.25,7],[44.24,7.0069444444444],[44.123333333333,7.4183333333333],[44.15,7.6166666666667],[44.166666666667,7.6333333333333],[44.166666666667,7.6666666666667],[44.125,7.6666666666667],[44.083333333333,7.7166666666667],[44.05,7.7],[44.033333333333,7.6666666666667],[44,7.6666666666667],[43.966111111111,7.6375],[43.9,7.55],[43.783333333333,7.5333333333333],[43.570277777778,8.3216666666667],[43.166666666667,9.75],[41.333333333333,9.75],[41.333333333333,8.3333333333333],[41,8],[39,8],[39,4.6666666666667],[42,4.6666666666667],[42.35,3.5],[42.435,3.175],[42.5,3],[42.458333333333,2.8833333333333],[43,2.275],[43.258333333333,2.5722222222222],[43.2125,2.7069444444444],[43.714722222222,2.7094444444444],[44.624722222222,3.0411111111111]];
                    L.polygon(lfmmLatLong, firDesign).addTo(map);
                  @endif
                  </script>
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
