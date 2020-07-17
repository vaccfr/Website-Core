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
          <h1>Admin Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

      </div>
      <div class="col-md-9">
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Members</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>Name</th>
                <th>Vatsim ID</th>
                <th>Member type</th>
                <th>ATC Rank</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($members as $m)
                  <tr>
                    <td>{{ $m['fname'] }} {{ $m['lname'] }}</td>
                    <td>{{ $m['vatsim_id'] }}</td>
                    <td>{{ $m['account_type'] }}</td>
                    <td>{{ $m['atc_rating_short'] }}</td>
                    <td></td>
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