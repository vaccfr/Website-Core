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
          <h1>{{__('app/admin/useredit.header_title', ['FNAME' => $user->fname])}}</h1>
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
      <div class="card card-info card-outline elevation-3">
        <div class="card-body box-profile">
          <h3 class="profile-username text-center">{{ $user->fullname() }}</h3>

          <p class="text-muted text-center">{{ $user->account_type }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.discord')}}</b> <a class="float-right">@if ($user->linked_discord == true)
                {{$user['discord']['username']}}
              @else
                <i>{{__('app/admin/useredit.not_linked')}}</i>
              @endif</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.atc_rank')}}</b> <a class="float-right">{{ $user->fullAtcRank() }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.pilot_rank')}}</b> <a class="float-right">P{{ $user->pilot_rating }}</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.approved_atc')}}</b> <a class="float-right">@if ($user->isApprovedAtc() == true)
                {{__('app/admin/useredit.approved')}}
              @else
                {{__('app/admin/useredit.not_approved')}}
              @endif</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.staff_status')}}</b> <a class="float-right">@if ($user->isStaff() == true)
                {{__('app/admin/useredit.approved')}}
              @else
                {{__('app/admin/useredit.not_approved')}}
              @endif</a>
            </li>
            <li class="list-group-item">
              <b>{{__('app/admin/useredit.mentor_status')}}</b> <a class="float-right">@if ($user->isAtcMentor() == true)
                {{__('app/admin/useredit.approved')}}
              @else
                {{__('app/admin/useredit.not_approved')}}
              @endif</a>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6">
          {{-- Edit User details --}}
          <div class="card card-dark elevation-3">
            <div class="card-header">
              <h3 class="card-title">{{__('app/admin/useredit.edit_details', ['FNAME' => $user->fname])}}</h3>
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
                      <label class="custom-control-label" for="approved-atc-switch">{{__('app/admin/useredit.approve_atc')}}</label>
                    </div>
                  </div>
                @endif
                <div class="form-group">
                  <label>{{__('app/admin/useredit.mod_usertype')}}</label>
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
                <button type="submit" class="btn btn-success">{{__('app/admin/useredit.submit')}}</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          {{-- Edit ATC Mentor status --}}
          <div class="card card-dark elevation-3">
            <div class="card-header">
              <h3 class="card-title">{{__('app/admin/useredit.edit_atc_mentor', ['FNAME' => $user->fname])}}</h3>
            </div>
            <form role="form" action="{{ route('app.staff.admin.edit.atcmentor', app()->getLocale()) }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="atcmentorswitch" name="atcmentorswitch" @if ($user->isAtcMentor() == true) checked @endif>
                    <label class="custom-control-label" for="atcmentorswitch">{{__('app/admin/useredit.make_atc_mentor')}}</label>
                  </div>
                </div>
                <div class="form-group">
                  <label>{{__('app/admin/useredit.allowed_mentor_lvl')}}</label>
                    <select class="form-control" name="allowedrank" id="allowedrank">
                      @foreach ($mentoring_ranks as $r)
                        @if ($r == $curr_mentor_rank)
                          <option value="{{ $r }}" selected>{{ $r }}</option>
                        @else
                          <option value="{{ $r }}">{{ $r }}</option>
                        @endif
                      @endforeach
                    </select>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <input type="hidden" name="userid" value="{{ $user->id }}">
                <button type="submit" class="btn btn-success">{{__('app/admin/useredit.submit')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          {{-- Edit User staff access --}}
          <div class="card card-dark elevation-3">
            <div class="card-header">
              <h3 class="card-title">{{__('app/admin/useredit.edit_staff', ['FNAME' => $user->fname])}}</h3>
            </div>
            @if (Auth::user()->isAdmin() == true)
            <form role="form" action="{{ route('app.staff.admin.edit.staffstatus', app()->getLocale()) }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="approved-staff-switch" name="staffswitch" @if ($user->isStaff() == true) checked @endif>
                    <label class="custom-control-label" for="approved-staff-switch">{{__('app/admin/useredit.make_staff')}}</label>
                  </div>
                </div>
                @if ($user->isStaff() == true)
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="admin-rights-switch" name="adminswitch" @if ($user->isAdmin() == true) checked @endif>
                    <label class="custom-control-label" for="admin-rights-switch">{{__('app/admin/useredit.make_admin')}}</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="exec-rights-switch" name="execswitch" @if ($user->isExecStaff() == true) checked @endif>
                    <label class="custom-control-label" for="exec-rights-switch">{{__('app/admin/useredit.make_exec')}}</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="events-rights-switch" name="eventswitch" @if ($user->isEventsStaff() == true) checked @endif>
                    <label class="custom-control-label" for="events-rights-switch">{{__('app/admin/useredit.make_events')}}</label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="stafftitle">{{__('app/admin/useredit.staff_title')}}</label>
                  <input type="text" class="form-control" name="stafftitle" id="stafftitle" @if (!is_null($staff->title)) value="{{ $staff->title }}" @else placeholder="{{__('app/admin/useredit.staff_title')}}" @endif>
                </div>             
                @endif
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <input type="hidden" name="userid" value="{{ $user->id }}">
                <button type="submit" class="btn btn-success">{{__('app/admin/useredit.submit')}}</button>
              </div>
            </form>
            @else
            <div class="card-body">
              <i>Vous n'êtes pas administrateur</i>
            </div>
            @endif
          </div>
        </div>
        <div class="col-md-6"></div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection