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
    <div class="card card-primary card-tabs elevation-3">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{__('app/app_menus.be')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">{{__('app/app_menus.es')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('app/app_menus.ch')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">{{__('app/app_menus.uk')}}</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
            <iframe src="{{ asset('assets/LOAS/LOA_France_Belgium.pdf') }}" frameborder="0" width="100%" height="800px"></iframe>
          </div>
          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
            <iframe src="{{ asset('assets/LOAS/LOA_France_Espagne.pdf') }}" frameborder="0" width="100%" height="800px"></iframe>
          </div>
          <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
            <iframe src="{{ asset('assets/LOAS/LOA_LSAS_LFFF_LFEE_LFMM.pdf') }}" frameborder="0" width="100%" height="800px"></iframe>
          </div>
          <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
            <iframe src="{{ asset('assets/LOAS/LOA_FRANCE_UK_V2.pdf') }}" frameborder="0" width="100%" height="800px"></iframe>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection