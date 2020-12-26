@extends('layouts.app')

@section('page-title')
  Tools | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/atc/tools.header')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/atc/tools.atis_title')}}</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <label for="atisurl">{{__('app/atc/tools.atis_urltitle')}}</label>
                <div class="input-group">
                  <input class="form-control" id="atisurl" type="text" readonly value="{{ $url }}">
                  <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" onclick="copyAtisToClip()">{{__('app/atc/tools.atis_cpy')}}</button>
                  </span>
                </div>
              </div>
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
              <script>
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });
                function copyAtisToClip() {
                  var copyText = document.getElementById("atisurl");
                  copyText.select();
                  copyText.setSelectionRange(0, 99999); /*For mobile devices*/
                  document.execCommand("copy");
                  Toast.fire({
                    icon: 'info',
                    title: "{{__('app/atc/tools.atis_copied')}}"
                  });
                }
              </script>
            </div>
            <div class="row pt-2">
              <div class="col-md-12">
                <div class="card card-primary">
                  <form role="form" action="{{ route('app.atc.tools.atisgen', app()->getLocale()) }}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="apptype">{{__('app/atc/tools.atis_app')}}</label>
                        <input type="text" class="form-control" id="apptype" name="apptype" value="{{ $apptype }}" placeholder='Ex: "ILS" / Ex: "RNAV A, VPT"'>
                      </div>
                      <div class="form-group">
                        <label for="sid">SID</label>
                        <input type="text" class="form-control" id="sid" name="sid" value="{{ $sid }}" placeholder='Ex: "2A" / Ex: "3A, 3B"'>
                      </div>
                      <div class="form-group">
                        <label for="info">{{__('app/atc/tools.atis_info')}}</label>
                        <input type="text" class="form-control" id="info" name="info" value="{{ $info }}" placeholder='Ex: "{{__('app/atc/tools.atis_info_ex')}}"'>
                      </div>
                      <div class="form-group">
                        <label for="crwy">{{__('app/atc/tools.atis_crwy')}}</label>
                        <input type="text" class="form-control" id="crwy" name="crwy" value="{{ $crwy }}" placeholder='Ex: "26L,26R" / Ex: "04L"'>
                      </div>
                      <div class="form-group">
                        <label for="ctwy">{{__('app/atc/tools.atis_ctwy')}}</label>
                        <input type="text" class="form-control" id="ctwy" name="ctwy" value="{{ $ctwy }}" placeholder='Ex: "A" / Ex: "Q, E, B2"'>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="birds" name="birds" @if ($birds == true) checked @endif>
                        <label class="form-check-label" for="birds">{{__('app/atc/tools.atis_birds')}}</label>
                      </div>
                    </div>    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-success">{{__('app/atc/tools.atis_generate')}}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if 69 > 34
      <div class="col-md-6">
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/atc/tools.freq_title')}}</h3>
          </div>
          <div class="card-body">
            <table
              id="freq-table"
              class="table table-bordered table-hover mt-3"
              data-order='[[ 0, "asc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/atc/tools.freq_pos')}}</th>
                <th>{{__('app/atc/tools.freq_name')}}</th>
                <th>{{__('app/atc/tools.freq_type')}}</th>
                <th>{{__('app/atc/tools.freq_freq')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($airport as $a)
                  @foreach ($a['positions'] as $p)
                  <tr>
                    <td>{{$p['code']}}</td>
                    <td>{{$p['callsign']}}</td>
                    <td>{{$p['type']}}</td>
                    <td>{{$p['frequency']}}</td>
                  </tr>
                  @endforeach
                  @if (!strlen($a['atis_frequency']) == 0)
                  <tr>
                    <td>{{$a['icao']}}_ATIS</td>
                    <td>{{$a['city']}} {{$a['airport']}}</td>
                    <td>ATIS</td>
                    <td>{{$a['atis_frequency']}}</td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <script>
          $('#freq-table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "responsive": true,
            "scrollY": 505,
            "language": {
              "emptyTable": "Error Loading Stations"
            }
          });
        </script>
      </div>
      @endif
    </div>
  </div>
@endsection