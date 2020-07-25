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
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('app.user.settings', app()->getLocale()) }}">{{__('app/app_menus.my_settings')}}</a></li>
          </ol>
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
          <div class="widget-user-header text-white" style="background: url({{ asset('media/img/lp/banner3.jpg') }}) center center;">
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
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.atc_hours')}}</span>
            <span class="info-box-number">{{ $atcTimes }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-plane-departure"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.pilot_hours')}}</span>
            <span class="info-box-number">{{ $pilotTimes }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.most_ctr_pos')}}</span>
            <span class="info-box-number">{{ $mostControlled }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">{{__('app/app_indexpage.your_last_atc')}}</h3>
          </div>
          <div class="card-body">
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
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">{{__('app/app_indexpage.your_last_flights')}}</h3>
          </div>
          <div class="card-body">
            <table
              id="flights_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/app_indexpage.callsign')}}</th>
                <th>Flight time</th>
                <th>Flight start</th>
                <th>Flight end</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($flights as $f)
                  <tr>
                    <td>{{ $f['callsign'] }}</td>
                    <td>{{ $f['duration'] }}</td>
                    <td>{{ $f['start_time'] }}</td>
                    <td>{{ $f['end_time'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
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
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": true,
      "info": false,
      "scrollY": 400,
      "language": {
        "emptyTable": "{{__('app/app_indexpage.no_last_atc')}}"
      }
    });
    $('#flights_table').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": true,
      "info": false,
      "scrollY": 400,
      "language": {
        "emptyTable": "{{__('app/app_indexpage.no_last_flights')}}"
      }
    });
  </script>
@endsection