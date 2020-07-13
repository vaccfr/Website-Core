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
          <h1>Welcome back, {{ Auth::user()->fname }}!</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Home</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">
      Example card I can work with rn
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      Card footer (if needed)
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Your last ATC sessions</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>Callsign</th>
          <th>Time spent</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($sessions as $sess)
            <tr>
              <td>{{ $sess['callsign'] }}</td>
              <td>{{ $sess['minutes_on_callsign'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection