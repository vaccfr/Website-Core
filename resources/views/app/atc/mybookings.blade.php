@extends('layouts.app')

@section('page-title')
  My ATC Bookings | {{ Auth::user()->fname }}
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
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Book a position</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control" id="position" placeholder="position">
              </div>
              <div class="form-group">
                <label for="starttime">Start</label>
                <input type="text" class="form-control" id="starttime" placeholder="Start time">
              </div>
              <div class="form-group">
                <label for="endtime">End</label>
                <input type="text" class="form-control" id="endtime" placeholder="End time">
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
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