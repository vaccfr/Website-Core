@extends('layouts.app')

@section('page-title')
  Admin | Edit {{ $user->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Admin Dashboard - Edit {{ $user->fname }}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <h3 class="profile-username text-center">{{ $user->fullname() }}</h3>

          <p class="text-muted text-center">{{ $user->account_type }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>{{__('app_indexpage.atc_rank')}}</b> <a class="float-right">{{ $user->fullAtcRank() }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app_indexpage.pilot_rank')}}</b> <a class="float-right">{{ $user->pilot_rating }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app_indexpage.approved_atc')}}</b> <a class="float-right">@if ($user->isApprovedAtc() == true)
                {{__('app_indexpage.approved')}}
              @else
                {{__('app_indexpage.not_approved')}}
              @endif</a>
            </li>
            <li class="list-group-item">
              <b>Staff Status</b> <a class="float-right">@if ($user->isStaff() == true)
                {{__('app_indexpage.approved')}}
              @else
                {{__('app_indexpage.not_approved')}}
              @endif</a>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-4">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit User Details</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{ route('app.staff.admin.edit.details', app()->getLocale()) }}" method="POST">
          @csrf
          <div class="card-body">
            @if (strpos($user->account_type, 'ATC') !== False)
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" id="approved-atc-switch" name="approveatc" @if ($user->isApprovedAtc() == true) checked @endif>
                  <label class="custom-control-label" for="approved-atc-switch">Approved ATC</label>
                </div>
              </div>
            @endif
            <div class="form-group">
              <label>Select</label>
                <select class="form-control" name="editusertype">
                  @foreach ($usertypes as $ut)
                    @if ($ut == $user->account_type)
                      <option value="{{ $ut }}" selected>{{ $ut }}</option>
                    @else
                      <option value="{{ $ut }}">{{ $ut }}</option>
                    @endif
                  @endforeach
                </select>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <input type="hidden" name="userid" value="{{ $user->id }}">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit User Staff Access</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{ route('app.staff.admin.edit.staffstatus', app()->getLocale()) }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-on-success">
                <input type="checkbox" class="custom-control-input" id="approved-staff-switch" name="staffswitch" @if ($user->isStaff() == true) checked @endif>
                <label class="custom-control-label" for="approved-staff-switch">Make Staff</label>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <input type="hidden" name="userid" value="{{ $user->id }}">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection