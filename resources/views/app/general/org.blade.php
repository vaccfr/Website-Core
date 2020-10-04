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
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3">
      <div class="card card-widget widget-user elevation-3">
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
                <h5 class="description-header">Director General</h5>
                <span class="description-text"><i>Full Time</i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-widget widget-user elevation-3">
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
                <h5 class="description-header">Deputy Director</h5>
                <span class="description-text"><i>Ad interim</i></span>
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
          <div class="card card-widget widget-user elevation-3">
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
                    <h5 class="description-header">ATC TD & Director of Operations</h5>
                    <span class="description-text"><i>Full Time</i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info elevation-3">
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 50%">Position</th>
                    <th style="width: 50%">Who</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Deputy ATC Training Director</td>
                    <td>Peter Paré - ACCFR31 (<i>Ad interim</i>)</td>
                  </tr>
                  <tr>
                    <td>Operations Lead</td>
                    <td>(Vacant) - ACCFR32</td>
                  </tr>
                  <tr>
                    <td>Pilot Training Lead</td>
                    <td>(Vacant) ACCFR33</td>
                  </tr>
                  <tr>
                    <td>Instructor & Examiner Team</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-block btn-info" data-toggle="modal" data-target="#examiner_instructor_team">
                        View team
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal fade" id="examiner_instructor_team">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-body p-0">
                <table class="table table-striped">
                  <thead>
                    <th>Role</th>
                    <th>Name & CID</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Examiner & Instructor</td>
                      <td>F-X Obert (1086470)</td>
                    </tr>
                    <tr>
                      <td>Examiner & Instructor</td>
                      <td>Peter Paré (1267123)</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_all.motiv_close')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user elevation-3">
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
                    <h5 class="description-header">Head of Marketing</h5>
                    <span class="description-text"><i>Full Time</i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info elevation-3">
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 50%">Position</th>
                    <th style="width: 50%">Who</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Events Lead</td>
                    <td>(Vacant) - ACCFR41</td>
                  </tr>
                  <tr>
                    <td>Marketing Support Team</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-block btn-info" data-toggle="modal" data-target="#marketing_team">
                        View team
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal fade" id="marketing_team">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-body p-0">
                <table class="table table-striped">
                  <thead>
                    <th>Role</th>
                    <th>Name & CID</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>(Vacant)</td>
                      <td>(Vacant)</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_all.motiv_close')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-widget widget-user elevation-3">
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
                    <h5 class="description-header">Head of Digital Services</h5>
                    <span class="description-text"><i>Full Time</i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info elevation-3">
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 50%">Position</th>
                    <th style="width: 50%">Who</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Digital Services Team</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-block btn-info" data-toggle="modal" data-target="#digital_team">
                        View team
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal fade" id="digital_team">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <th>Role</th>
                      <th>Name & CID</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Graphics & Web Design</td>
                        <td>Reda Khermach (1478229)</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_all.motiv_close')}}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-right">
      <div class="card card-widget widget-user elevation-3">
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
                <h5 class="description-header">Head of Membership</h5>
                <span class="description-text"><i>Full Time</i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection