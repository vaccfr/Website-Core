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
        <div class="card-body">
          <i>(Work in progress)</i>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection