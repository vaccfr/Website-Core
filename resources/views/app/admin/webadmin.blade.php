@extends('layouts.app')

@section('page-title')
  Web Admin
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Web Admin Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-bug"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Exceptions today</span>
            <span class="info-box-number">{{ $exceptionsToday }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total visitors today</span>
            <span class="info-box-number">{{ $totalToday }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Members only</span>
            <span class="info-box-number">{{ $membersToday }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user-tag"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Visitors only</span>
            <span class="info-box-number">{{ $visitorsToday }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- /.card -->
        <div class="card card-outline card-primary">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">Exception Logs</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="exception_logs_table"
              class="table table-bordered table-hover"
              data-order='[[ 4, "desc" ]]'>
              <thead>
              <tr>
                <th>ID</th>
                <th>User name</th>
                <th>User CID</th>
                <th>URL</th>
                <th>Details</th>
                <th>Timestamp</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($exceptions as $e)
                <tr>
                  <td>{{ $e['id'] }}</td>
                  @if (is_null($e['user']))
                    <td>(no user)</td>
                    <td>(no user)</td>
                  @else
                    <td>{{ $e['user']['fname'] }} {{ $e['user']['lname'] }}</td>
                    <td>{{ $e['user']['vatsim_id'] }}</td>
                  @endif
                  <td>{{ $e['url'] }}</td>
                  <td>
                    <button type="button" class="btn btn-flat btn-info btn-block" data-toggle="modal" data-target="#details_{{$e['id']}}">
                      View details
                    </button>
                  </td>
                  <td>{{ $e['created_at'] }}</td>
                </tr>
                <div class="modal fade" id="details_{{$e['id']}}">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Details of Exception ID {{$e['id']}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="msg_{{$e['id']}}">Message</label>
                          <textarea name="msg_{{$e['id']}}" id="msg_{{$e['id']}}" class="form-control" rows="5" style="resize: none;" readonly>{{ $e['message'] }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="file_{{$e['id']}}">File at line <b>{{ $e['line'] }}</b></label>
                          <textarea name="file_{{$e['id']}}" id="file_{{$e['id']}}" class="form-control" rows="5" style="resize: none;" readonly>{{ $e['file'] }}</textarea>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
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
    $('#exception_logs_table').DataTable({
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