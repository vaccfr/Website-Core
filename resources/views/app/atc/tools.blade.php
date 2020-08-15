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
          <h1>ATC Tools / Outils ATC</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">ATIS URL</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="atisurl">ATIS URL:</label>
                  <input class="form-control" id="atisurl" type="text" readonly value="{{ $url }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                  <form role="form" action="{{ route('app.atc.tools.atisgen', app()->getLocale()) }}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="apptype">Approach / Approche</label>
                        <input type="text" class="form-control" id="apptype" name="apptype" value="{{ $apptype }}" placeholder='Ex: "ILS" / Ex: "RNAV A, VPT"'>
                      </div>
                      <div class="form-group">
                        <label for="sid">SID</label>
                        <input type="text" class="form-control" id="sid" name="sid" value="{{ $sid }}" placeholder='Ex: "2A" / Ex: "3A, 3B"'>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="birds" name="birds" @if ($birds == true) checked @endif>
                        <label class="form-check-label" for="birds">Bird activity / Activité aviaire</label>
                      </div>
                    </div>    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection