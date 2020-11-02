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
          <h1>Stand API Editor - Stands</h1>
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
                  <button type="button" class="btn btn-success btn-block elevation-1" data-toggle="modal" data-target="#new_stand">New Stand @if (!is_null($currentIcao)) for {{$currentIcao}} @endif</button>
                </td>
              </tr>
              <div class="modal fade" id="new_stand">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">New Stand @if (!is_null($currentIcao)) for {{$currentIcao}} @endif</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{route('app.atc.cofrance.stands.create', app()->getLocale())}}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="airporticao">Airport ICAO</label>
                              <input type="text" class="form-control" id="airporticao" name="airporticao" placeholder="Airport ICAO" @if (!is_null($currentIcao)) readonly value="{{$currentIcao}}" @else required @endif>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="standnumber">Stand</label>
                              <input required type="text" class="form-control" id="standnumber" name="standnumber" placeholder="Stand number">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="coordinates-lat">Latitude</label>
                              <input required type="text" class="form-control" id="coordinates-lat" name="coordinates-lat" placeholder="Decimal latitude">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="coordinates-lon">Longitude</label>
                              <input required type="text" class="form-control" id="coordinates-lon" name="coordinates-lon" placeholder="Decimal longitude">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="companies">Companies</label>
                          <input type="text" class="form-control" id="companies" name="companies" placeholder="Companies">
                        </div>
                        <div class="row">
                          <div class="col-md-4 border-right border-bottom">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="schengentoggle" name="schengentoggle">
                                <label class="custom-control-label" for="schengentoggle">Schengen Stand?</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 border-right border-bottom">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="opentoggle" name="opentoggle">
                                <label class="custom-control-label" for="opentoggle">Stand Open / Closed</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 border-bottom">
                            <div class="form-group">
                              <label>Selection Priority</label>
                              <select class="form-control" id="priorityselect" name="priorityselect">
                                <option selected value="3">3 (High)</option>
                                <option value="2">2 (Medium)</option>
                                <option value="1">1 (Low)</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-md-6 border-right">
                            <div class="form-group">
                              <label>Wake Turbulence Category</label>
                              @foreach ($wtc_conversion as $wtce)
                              <div class="form-check">
                                <input
                                  class="form-check-input"
                                  type="checkbox"
                                  name="swtc_{{array_keys($wtc_conversion, $wtce)[0]}}">
                                <label class="form-check-label">{{$wtce}}</label>
                              </div>
                              @endforeach
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label>Aircraft Types</label>
                            @foreach ($stand_users as $su)
                            <div class="form-check">
                              <input 
                                class="form-check-input"
                                type="checkbox"
                                name="su_{{array_keys($stand_users, $su)[0]}}">
                              <label class="form-check-label">{{$su}}</label>
                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                        <button type="submit" class="btn btn-success">Create Stand</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @if (!is_null($currentIcao))
              <tr>
                <td>
                  <button type="button" class="btn btn-danger btn-block elevation-1" data-toggle="modal" data-target="#delete_stand">Delete Stand @if (!is_null($currentIcao)) in {{$currentIcao}} @endif</button>
                </td>
              </tr>
              <div class="modal fade" id="delete_stand">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete Stand @if (!is_null($currentIcao)) in {{$currentIcao}} @endif</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{route('app.atc.cofrance.stands.delete', app()->getLocale())}}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Select stand to delete</label>
                          <select class="form-control" name="stand">
                            @foreach ($data as $d)
                            <option value="{{$d['id']}}">{{$d['stand']}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                          <button type="submit" class="btn btn-success">Delete Stand</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', app()->getLocale())}}" class="btn btn-warning btn-block elevation-1">Reset</a>
                </td>
              </tr>
              @endif
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', ['locale' => app()->getLocale(), 'airlines' => true])}}" class="btn btn-info btn-block elevation-1">Airline View</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">
            Useful tools
          </h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>
                  <a href="https://www.rapidtables.com/convert/number/degrees-minutes-seconds-to-degrees.html" target="_blank" class="btn btn-block btn-info elevation-1">Degrees-Minute-Second to Decimal Degrees</a>
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
              <th>Schengen</th>
              <th>Open</th>
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
                  $final_wtc_list = [];
                  foreach (explode(',', $d->wtc) as $val) {
                    array_push($final_wtc_list, $wtc_conversion[$val]);
                  }
                  ?>
                  <td>{{$d['stand']}}</td>
                  <td style="word-break:break-all;">{{$d['companies']}}</td>
                  <td>{{implode(', ', $final_wtc_list)}}</td>
                  <td>{{implode(', ', $final_usage_list)}}</td>
                  <td>
                    @if ($d['schengen'] == true)
                    <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                    @else
                    <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                    @endif
                  </td>
                  <td>
                    @if ($d['is_open'] == true)
                    <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                    @else
                    <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                    @endif
                  </td>
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
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="standnumber">Stand</label>
                                <input type="text" class="form-control" id="standnumber" name="standnumber" placeholder="Stand" value="{{$d['stand']}}">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="coordinates-lat">Latitude</label>
                                <input type="text" class="form-control" id="coordinates-lat" name="coordinates-lat" placeholder="Latitude" value="{{$d['lat']}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="coordinates-lon">Longitude</label>
                                <input type="text" class="form-control" id="coordinates-lon" name="coordinates-lon" placeholder="Longitude" value="{{$d['lon']}}">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="companies">Companies</label>
                            <input type="text" class="form-control" id="companies" name="companies" placeholder="Companies" value="{{$d['companies']}}">
                          </div>
                          <div class="row">
                            <div class="col-md-4 border-right border-bottom">
                              <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                  <input @if ($d->schengen == true) checked @endif type="checkbox" class="custom-control-input" id="schengentoggle{{$d['id']}}" name="schengentoggle{{$d['id']}}">
                                  <label class="custom-control-label" for="schengentoggle{{$d['id']}}">Schengen Stand?</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4 border-right border-bottom">
                              <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                  <input @if ($d->is_open == true) checked @endif type="checkbox" class="custom-control-input" id="opentoggle{{$d['id']}}" name="opentoggle{{$d['id']}}">
                                  <label class="custom-control-label" for="opentoggle{{$d['id']}}">Stand Open / Closed</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4 border-bottom">
                              <div class="form-group">
                                <label>Selection Priority</label>
                                <select class="form-control" id="priorityselect" name="priorityselect">
                                  <option selected value="{{$d->priority}}">{{$d->priority}} ({{$priority_selectors[$d->priority]}})</option>
                                  @if ($d->priority != 3)<option value="3">3 (High)</option>@endif
                                  @if ($d->priority != 2)<option value="2">2 (Medium)</option>@endif
                                  @if ($d->priority != 1)<option value="1">1 (Low)</option>@endif
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-6 border-right">
                              <div class="form-group">
                                <label>Wake Turbulence Category</label>
                                @foreach ($wtc_conversion as $wtce)
                                <div class="form-check">
                                  <input
                                    @if (in_array(array_keys($wtc_conversion, $wtce)[0], explode(',', $d->wtc))) checked @endif
                                    class="form-check-input"
                                    type="checkbox"
                                    name="swtc_{{array_keys($wtc_conversion, $wtce)[0]}}">
                                  <label class="form-check-label">{{$wtce}}</label>
                                </div>
                                @endforeach
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