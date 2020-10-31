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
    <div class="col-md-2">
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
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">Functions</h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead></thead>
            <tbody>
              <tr>
                <td>
                  <button type="button" class="btn btn-success btn-block elevation-1">New Stand @if (!is_null($currentIcao)) for {{$currentIcao}} @endif</button>
                </td>
              </tr>
              <tr>
                <td>
                  <button type="button" class="btn btn-danger btn-block elevation-1">Delete Stand @if (!is_null($currentIcao)) in {{$currentIcao}} @endif</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @if (count($data) > 0)
    <div class="col-md-10">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">{{$data[0]['icao']}}</h3>
        </div>
        <div class="card-body">
          <table
            id="{{$data[0]['icao']}}_stands"
            class="table table-bordered table-hover"
            data-order='[[ 0, "asc" ]]'>
            <thead>
            <tr>
              <th>Stand</th>
              <th>Companies</th>
              <th>WTC</th>
              <th>Users</th>
              <th>Edit</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  <?php
                  $final_usage_list = [];
                  foreach (explode(',', $d->usage) as $val) {
                      array_push($final_usage_list, $stand_users[$val]);
                  }
                  ?>
                  <td>{{$d['stand']}}</td>
                  <td>{{$d['companies']}}</td>
                  <td>{{$wtc_equivalences[$d['wtc']]}} (and below)</td>
                  <td>{{implode(', ', $final_usage_list)}}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-success btn-block elevation-1"
                      data-toggle="modal"
                      data-target="#editor-{{$loop->index}}"
                    >
                      Edit {{$d['stand']}}
                    </button>
                  </td>
                </tr>
                <div class="modal fade" id="editor-{{$loop->index}}">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit stand {{$d['stand']}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{route('app.atc.cofrance.stands.edit', app()->getLocale())}}" method="post">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="coordinates-lat">Latitude</label>
                            <input type="text" class="form-control" id="coordinates-lat" name="coordinates-lat" placeholder="Latitude" value="{{$d['lat']}}">
                          </div>
                          <div class="form-group">
                            <label for="coordinates-lon">Longitude</label>
                            <input type="text" class="form-control" id="coordinates-lon" name="coordinates-lon" placeholder="Longitude" value="{{$d['lon']}}">
                          </div>
                          <div class="form-group">
                            <label for="companies">Companies</label>
                            <input type="text" class="form-control" id="companies" name="companies" placeholder="Companies" value="{{$d['companies']}}">
                          </div>
                          <div class="row">
                            <div class="col-md-6 border-right">
                              <div class="form-group">
                                <label>Wake Turbulence Category</label>
                                <select class="form-control" name="wtcvalue">
                                    <option selected value="{{$d['wtc']}}">{{$wtc_equivalences[$d['wtc']]}}</option>
                                    @foreach ($wtc_equivalences as $wtce)
                                    @if ($loop->index+1 != $d['wtc'])
                                    <option value="{{$loop->index+1}}">{{$wtc_equivalences[$loop->index+1]}}</option>
                                    @endif
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label>Aircraft Types</label>
                              @foreach ($stand_users as $su)
                              <div class="form-check">
                                <input 
                                  @if (in_array(array_keys($stand_users, $su)[0], explode(',', $d->usage))) checked @endif
                                  class="form-check-input"
                                  type="checkbox"
                                  name="su_{{array_keys($stand_users, $su)[0]}}">
                                <label class="form-check-label">{{$su}}</label>
                              </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                        <input type="hidden" name="standid" value="{{$d['id']}}">
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                          <button type="submit" class="btn btn-success">Submit Data</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
        "paging": true,
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