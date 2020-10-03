@extends('layouts.app')

@section('page-title')
{{__('app/app_menus.staff_org')}}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/app_menus.staff_org')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">Pierre Ferran</h3>
          <h5 class="widget-user-desc">ACCFR1</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header"><i>Full time position</i></h5>
                <span class="description-text">Director General</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">F-X Obert</h3>
          <h5 class="widget-user-desc">ACCFR2</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header"><i>Ad interim</i></h5>
                <span class="description-text">Deputy Director</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>

  <div class="row">
    <div class="col-md-3 border-right">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info">
              <h3 class="widget-user-username">F-X Obert</h3>
              <h5 class="widget-user-desc">ACCFR3</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-12">
                  <div class="description-block">
                    <h5 class="description-header"><i>Full time position</i></h5>
                    <span class="description-text">ATC Training Director & Director Operations</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info">
              <h3 class="widget-user-username">Peter Paré</h3>
              <h5 class="widget-user-desc">ACCFRxx</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-12">
                  <div class="description-block">
                    <h5 class="description-header"><i>Full time position</i></h5>
                    <span class="description-text">ATC Training Director & Director Operations</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">Fabrice R.</h3>
          <h5 class="widget-user-desc">ACCFR4</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header"><i>Full time position</i></h5>
                <span class="description-text">Head of Marketing</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">Peter Paré</h3>
          <h5 class="widget-user-desc">ACCFR5</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header"><i>Full time position</i></h5>
                <span class="description-text">Head of Digital Services</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">(Vacant)</h3>
          <h5 class="widget-user-desc">ACCFR6</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header"><i>Full time position</i></h5>
                <span class="description-text">Head of Membership</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection