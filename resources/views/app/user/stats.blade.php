@extends('layouts.app')

@section('page-title')
  Statistics | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Statistiques {{ Auth::user()->fname }}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-info"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.atc_hours')}}</span>
            <span class="info-box-number">{{ $atcTimes }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
          <div class="info-box-content" data-toggle="tooltip" data-placement="top" title="{{__('app/app_indexpage.last_100_conns')}}">
            <span class="info-box-text">{{__('app/app_indexpage.most_ctr_pos')}}</span>
            <span class="info-box-number">{{ $mostControlled }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-info"><i class="fas fa-plane-departure"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/app_indexpage.pilot_hours')}}</span>
            <span class="info-box-number">{{ $pilotTimes }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-outline card-dark elevation-3">
          <div class="card-header" data-toggle="tooltip" data-placement="top" title="{{__('app/app_indexpage.last_100_conns')}}">
            <h3 class="card-title">{{__('app/app_indexpage.your_last_atc')}}</h3>
          </div>
        </div>
        <div class="card elevation-3">
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
        <div class="card card-outline card-dark elevation-3">
          <div class="card-header" data-toggle="tooltip" data-placement="top" title="{{__('app/app_indexpage.last_100_conns')}}">
            <h3 class="card-title">{{__('app/app_indexpage.your_last_flights')}}</h3>
          </div>
        </div>
        <div class="card elevation-3">
          <div class="card-body">
            <table
              id="flights_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/app_indexpage.fl_callsign')}}</th>
                {{-- <th>Flight duration</th> --}}
                <th>{{__('app/app_indexpage.fl_start')}}</th>
                <th>{{__('app/app_indexpage.fl_end')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($flights as $f)
                  <tr>
                    <td>{{ $f['callsign'] }}</td>
                    {{-- <td>{{ $f['duration'] }}</td> --}}
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
      "scrollY": 450,
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
      "scrollY": 450,
      "language": {
        "emptyTable": "{{__('app/app_indexpage.no_last_flights')}}"
      }
    });
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>
@endsection