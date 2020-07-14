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
          <h1>{{__('app_indexpage.welcomeback')}}, {{ Auth::user()->fname }}!</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <h3 class="profile-username text-center">{{ Auth::user()->fullname() }}</h3>

            <p class="text-muted text-center">{{ Auth::user()->account_type }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>{{__('app_indexpage.atc_rank')}}</b> <a class="float-right">{{ Auth::user()->fullAtcRank() }}</a>
              </li>
              <li class="list-group-item">
                <b>{{__('app_indexpage.pilot_rank')}}</b> <a class="float-right">{{ Auth::user()->pilot_rating }}</a>
              </li>
              <li class="list-group-item">
                <b>{{__('app_indexpage.atc_hours')}}</b> <a class="float-right">{{ $atcTimes }}</a>
              </li>
              <li class="list-group-item">
                <b>{{__('app_indexpage.pilot_hours')}}</b> <a class="float-right">{{ $pilotTimes }}</a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-9">
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{__('app_indexpage.your_last_atc')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app_indexpage.callsign')}}</th>
                <th>{{__('app_indexpage.sess_time')}}</th>
                <th>{{__('app_indexpage.sess_start')}}</th>
                <th>{{__('app_indexpage.sess_end')}}</th>
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
          <!-- /.card-body -->
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