@extends('layouts.app')

@section('page-title')
  LOAs | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Letters of Agreement</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="atis-url-tab"
              data-toggle="pill"
              href="#atis-url"
              role="tab"
              aria-controls="atis-url"
              aria-selected="true">
                ATIS URL
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="tools2-tab"
              data-toggle="pill"
              href="#tools2"
              role="tab"
              aria-controls="tools2"
              aria-selected="false">
                (empty)
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane fade show active" id="atis-url" role="tabpanel" aria-labelledby="atis-url-tab">
            <div class="row">
              <div class="col-md-4">
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
              <div class="col-md-8">
                <div class="form-group">
                  <input class="form-control" type="text" readonly value="{{ $url }}">
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tools2" role="tabpanel" aria-labelledby="tools2-tab">
            
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection