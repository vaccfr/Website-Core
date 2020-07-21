@extends('layouts.app')

@section('page-title')
  ATC Mentoring | My students
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ATC Mentoring - My students</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <link rel="stylesheet" href="{{ asset('dashboard/stepbar.css') }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Students</span>
            <span class="info-box-number">1</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Sessions</span>
            <span class="info-box-number">7</span>
          </div>
        </div>
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">Mentor's toolbox</h3>
          </div>
          <div class="card-body p-0">
            <table class="table">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Powerpoint utile</a></td>
                </tr>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Videos de chats</a></td>
                </tr>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Photos de Philippe devant le scope</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <div class="card card-outline @if(true) card-success @else card-danger @endif">
          <div class="card-header" data-card-widget="collapse">
            <h3 class="card-title">Emmanuel Macron - S2 - LFMN</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Student progress</h4>
                <div class="steps">
                  <ul class="steps-container">
                    @foreach ($steps as $s)
                    @php
                      $now = ($loop->index + 1)*$progSteps;
                      if ($now > $progCurrent) {
                        $now = false;
                      } else {
                        $now = true;
                      }
                    @endphp
                    <li style="width:{{ $progSteps }}%;" @if ($now) class="activated" @endif>
                      <div class="step">
                        <div class="step-image"><span></span></div>
                        <div class="step-current">{{ $s['type'] }}</div>
                        <div class="step-description">{{ $s['title'] }}</div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  <div class="step-bar" style="width: {{ $progCurrent }}%;"></div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-9 border-right">
                <h4>Upcoming sessions</h4>
                <table
                  id="upcoming_sessions"
                  class="table table-bordered table-hover"
                  data-order='[[ 1, "desc" ]]'>
                  <thead>
                  <tr>
                    <th>Position</th>
                    <th>When</th>
                    <th>Scheduled by</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>LFMN_APP</td>
                      <td>DATE - TIME</td>
                      <td>Student (Emmanuel Macron)</td>
                      <td>Awaiting your approval</td>
                      <td>
                        <form action="" method="GET">
                          @csrf
                          <button type="submit" class="btn btn-block btn-success btn-flat"><i class="fa fa-check"></i></button>
                        </form>
                      </td>
                    </tr>
                    <tr>
                      <td>LFMN_TWR</td>
                      <td>DATE - TIME</td>
                      <td>You</td>
                      <td>Awaiting student approval</td>
                      <td>
                        <form action="" method="GET">
                          @csrf
                          <button type="submit" class="btn btn-block btn-danger btn-flat"><i class="fa fa-times"></i></button>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3">
                <h4>Actions</h4>
                <button type="button" class="btn btn-block btn-info btn-flat">Book Session</button>
                <button type="button" class="btn btn-block btn-danger btn-flat">Terminate Mentoring</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $('#upcoming_sessions').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "autoWidth": false,
      "info": false,
      "scrollY": 300,
    });
  </script>
@endsection