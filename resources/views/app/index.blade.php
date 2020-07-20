@extends('layouts.app')

@section('page-title')
  Home | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/app_indexpage.welcomeback')}}, {{ Auth::user()->fname }}!</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user">
          <div class="widget-user-header" style="background-image: url({{ asset('media/img/lp/banner3.jpg') }})">
            <h3 class="widget-user-username">{{ Auth::user()->fullname() }}</h3>
            <h5 class="widget-user-desc">{{ Auth::user()->account_type }}</h5>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">Vatsim ID</span>
                  <h5 class="description-header">{{ Auth::user()->vatsim_id }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">{{__('app/app_indexpage.atc_rank')}}</span>
                  <h5 class="description-header">{{ Auth::user()->fullAtcRank() }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">{{__('app/app_indexpage.pilot_rank')}}</span>
                  <h5 class="description-header">P{{ Auth::user()->pilot_rating }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3">
                <div class="description-block">
                  <span class="description-text">{{__('app/app_indexpage.approved_atc')}}</span>
                  <h5 class="description-header">@if (Auth::user()->isApprovedAtc() == true)
                    {{__('app/app_indexpage.approved')}}
                  @else
                    {{__('app/app_indexpage.not_approved')}}
                  @endif</h5>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.atc_hours')}}</span>
            <span class="info-box-number">{{ $atcTimes }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-plane-departure"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.pilot_hours')}}</span>
            <span class="info-box-number">{{ $pilotTimes }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.most_ctr_pos')}}</span>
            <span class="info-box-number">(N/A)</span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-outline card-info card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="last-atc-sessions-tab" data-toggle="pill" href="#last-atc-sessions" role="tab" aria-controls="last-atc-sessions" aria-selected="true">{{__('app/app_indexpage.your_last_atc')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="last-flights-tab" data-toggle="pill" href="#last-flights" role="tab" aria-controls="last-flights" aria-selected="false">{{__('app/app_indexpage.your_last_flights')}}</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              <div class="tab-pane fade show active" id="last-atc-sessions" role="tabpanel" aria-labelledby="last-atc-sessions-tab">
                <table
                  id="atc_sessions_table"
                  class="table table-bordered table-hover"
                  data-order='[[ 2, "desc" ]]'>
                  <thead>
                  <tr>
                    <th>{{__('app/app_indexpage.callsign')}}</th>
                    <th>{{__('app/app_indexpage.sess_time')}}</th>
                    <th>{{__('app/app_indexpage.sess_start')}}</th>
                    <th>{{__('app/app_indexpage.sess_end')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($sessions as $sess)
                      <tr>
                        <td>{{ $sess['callsign'] }}</td>
                        <td>{{ $sess['duration'] }}</td>
                        <td>{{ $sess['start_time'] }}</td>
                        <td>{{ $sess['end_time'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="last-flights" role="tabpanel" aria-labelledby="last-flights-tab">
                 Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-3">
        <div class="card card-outline card-info">
          <div class="card-body">
            <iframe src="https://discordapp.com/widget?id=649009573692440594&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $('#atc_sessions_table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": false,
      "scrollY": 400,
    });
  </script>
@endsection