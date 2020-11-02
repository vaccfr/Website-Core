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
              @if (!is_null($selectedAirline))
              <tr>
                <td>
                  <a href="{{route('app.atc.cofrance.stands', [
                    'locale' => app()->getLocale(),
                    'airlines' => true,
                  ])}}" class="btn btn-warning btn-block elevation-1">Reset</a>
                </td>
              </tr>
              @endif
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
              {{-- <tr>
                <td>
                  <a href="https://www.rapidtables.com/convert/number/degrees-minutes-seconds-to-degrees.html" target="_blank" class="btn btn-block btn-info elevation-1">Degrees-Minute-Second to Decimal Degrees</a>
                </td>
              </tr> --}}
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
        <div class="card-body @if (is_null($selectedAirline)) p-0 @endif" style="max-height: 400px; overflow-y: auto;">
          @if (is_null($selectedAirline))
          <table class="table">
            <thead>
            </thead>
            <tbody>
              @foreach ($airlinesList as $a)
              <tr>
                <td><a href="{{route('app.atc.cofrance.stands', [
                  'locale' => app()->getLocale(),
                  'airlines' => true,
                  'airline' => $a,
                ])}}">{{$a}}</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <b>{{$selectedAirline}}</b>
          @endif
        </div>
      </div>
      @if (!is_null($selectedAirline))
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">Relevant Airports</h3>
        </div>
        <div class="card-body p-0">
          <table class="table">
            <thead>
            </thead>
            <tbody>
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
            </tbody>
          </table>
        </div>
      </div>
      @endif
    </div>
    <div class="col-md-10">

    </div>
  </div>
</div>
@endsection