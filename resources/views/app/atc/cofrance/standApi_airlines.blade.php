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
          <h1>Stand API Editor - Airlines</h1>
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
          <h3 class="card-title">Functions</h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead></thead>
            <tbody>
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', app()->getLocale())}}" class="btn btn-info btn-block elevation-1">Stands View</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">
            @if (is_null($selectedAirline)) Available Airlines @else Selected Airline @endif
          </h3>
        </div>
        <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              @if (is_null($selectedAirline))
              @foreach ($airlinesList as $a)
              <tr>
                <td><a href="{{route('app.atc.cofrance.stands', [
                  'locale' => app()->getLocale(),
                  'airlines' => true,
                  'airline' => $a,
                ])}}">{{$a}}</a></td>
              </tr>
              @endforeach
              @else
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', [
                    'locale' => app()->getLocale(),
                    'airlines' => true,
                  ])}}" class="btn btn-danger btn-block elevation-1">{{$selectedAirline}}</a>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      @if (!is_null($selectedAirline))
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">@if (is_null($selectedAirport)) Relevant Airports @else Selected Airport @endif</h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              @if (is_null($selectedAirport))
              @foreach ($relevantAirports as $a)
              <tr>
                <td><a href="{{route('app.atc.cofrance.stands', [
                  'locale' => app()->getLocale(),
                  'airlines' => true,
                  'airline' => $selectedAirline,
                  'airport' => $a,
                ])}}">{{$a}}</a></td>
              </tr>
              @endforeach
              @else
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', [
                    'locale' => app()->getLocale(),
                    'airlines' => true,
                    'airline' => $selectedAirline,
                  ])}}" class="btn btn-danger btn-block elevation-1">{{$selectedAirport}}</a>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      @endif
    </div>
    <div class="col-md-10">
      @if (!is_null($selectedAirline) && !is_null($selectedAirport))
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">
            Airline: {{$selectedAirline}} | Airport: {{$selectedAirport}}
          </h3>
        </div>
        <form action="{{route('app.atc.cofrance.stands.editbyairline', app()->getLocale())}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 border-right">
                <div class="card card-dark card-outline elevation-1">
                  <div class="card-header">
                    <h3 class="card-title">Used stands</h3>
                  </div>
                  <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <table class="table" id="istable">
                      <thead>
                        <th>Stand</th>
                        <th>WTC</th>
                        <th>Usage</th>
                        <th>Schengen</th>
                        <th>Open?</th>
                        <th></th>
                      </thead>
                      <tbody>
                        @foreach ($relevantStands['is'] as $stand)
                        <tr>
                          <td>{{$stand['stand']}}</td>
                          <td>{{$stand['wtc']}}</td>
                          <td>{{$stand['usage']}}</td>
                          <td>
                            @if ($stand['schengen'] == true)
                            <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                            @else
                            <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                            @endif
                          </td>
                          <td>
                            @if ($stand['open'] == true)
                            <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                            @else
                            <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                            @endif
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input
                                checked
                                type="checkbox" 
                                class="custom-control-input"
                                id="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}"
                                name="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}">
                                <label class="custom-control-label" for="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}">Toggle</label>
                              </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-dark card-outline elevation-1">
                  <div class="card-header">
                    <h3 class="card-title"><i>Unused</i> stands</h3>
                  </div>
                  <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <table class="table" id="isnottable">
                      <thead>
                        <th>Stand</th>
                        <th>WTC</th>
                        <th>Usage</th>
                        <th>Schengen</th>
                        <th>Open?</th>
                        <th></th>
                      </thead>
                      <tbody>
                        @foreach ($relevantStands['isnot'] as $stand)
                        <tr>
                          <td>{{$stand['stand']}}</td>
                          <td>{{$stand['wtc']}}</td>
                          <td>{{$stand['usage']}}</td>
                          <td>
                            @if ($stand['schengen'] == true)
                            <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                            @else
                            <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                            @endif
                          </td>
                          <td>
                            @if ($stand['open'] == true)
                            <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                            @else
                            <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                            @endif
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input
                                type="checkbox" 
                                class="custom-control-input"
                                id="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}"
                                name="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}">
                                <label class="custom-control-label" for="toggle_stand_{{$stand['stand']}}_{{$selectedAirport}}">Toggle</label>
                              </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <input type="hidden" name="selectedcomp" value="{{$selectedAirline}}">
            <input type="hidden" name="selectedairp" value="{{$selectedAirport}}">
            <button type="submit" class="btn btn-block btn-success">Save</button>
          </div>
        </form>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection