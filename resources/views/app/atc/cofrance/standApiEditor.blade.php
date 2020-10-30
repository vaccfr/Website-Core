{{-- This page is a template for other webapp pages --}}

@extends('layouts.app')

@section('page-title')
  Stand API Editor
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Stand API Editor</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">
            Available Airports
          </h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              @foreach ($icaos as $i)
              <tr>
                <td><a href="{{route('app.atc.cofrance.stands', [
                  'locale' => app()->getLocale(),
                  'icao' => $i,
                ])}}">{{$i}}</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @if (count($data) > 0)
    <div class="col-md-9">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">{{$data[0]['icao']}}</h3>
        </div>
        <div class="card-body">
          <table
            id="{{$data[0]['icao']}}_stands"
            class="table table-bordered table-hover"
            data-order='[[ 1, "desc" ]]'>
            <thead>
            <tr>
              <th>Stand</th>
              <th>Lat/Lon</th>
              <th>Edit</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  <td>{{$d['stand']}}</td>
                  <td>{{$d['lat']}} / {{$d['lon']}}</td>
                  <td><a href="#" class="btn btn-success btn-block elevation-1" data-target="#edit_stand_{{$d['stand']}}" data-toggle="modal">Edit {{$d['stand']}}</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
    <script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
    <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
      $("#{{$data[0]['icao']}}_stands").DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "autoWidth": true,
        "info": true,
      });
    </script>
    @endif
  </div>
</div>
@endsection