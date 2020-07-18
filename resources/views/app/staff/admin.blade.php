@extends('layouts.app')

@section('page-title')
  Admin | {{ Auth::user()->fname }}
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
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Members</span>
            <span class="info-box-number">{{ $memberCount }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">ATC members</span>
            <span class="info-box-number">{{ $atcCount }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">ATC bookings today</span>
            <span class="info-box-number">{{ $bookingsCount }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-10">
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
                <th>Region</th>
                <th>Account</th>
                <th>Staff</th>
                <th>ATC Approval</th>
                <th>ATC Rank</th>
                <th>Pilot Rank</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($members as $m)
                  <tr>
                    <td>{{ $m['fname'] }} {{ $m['lname'] }}</td>
                    <td>{{ $m['vatsim_id'] }}</td>
                    <td>{{ $m['subdiv_id'] }} ({{ $m['subdiv_name'] }})</td>
                    <td>{{ $m['account_type'] }}</td>
                    <td>@if($m['is_staff'] == true) Yes @else No @endif</td>
                    <td>@if($m['is_approved_atc'] == true) Yes @else No @endif</td>
                    <td>{{ $m['atc_rating_short'] }}</td>
                    <td>P{{ $m['pilot_rating'] }}</td>
                    <td>
                      <div class="row">
                        <div class="col-sm-6">
                          <form action="{{ route('app.staff.admin.edit', ['locale' => app()->getLocale()]) }}" method="get">
                            <input type="hidden" value="{{ $m['id'] }}" name="userid">
                            <button type="submit" class="btn btn-block btn-info btn-flat">
                              Edit
                            </button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          <button type="button" class="btn btn-block btn-warning btn-flat">Restrict</button>
                        </div>
                      </div>
                    </td>
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  </script>
@endsection