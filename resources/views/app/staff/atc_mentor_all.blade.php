@extends('layouts.app')

@section('page-title')
  ATC Mentoring | Overview
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/staff/atc_all.header_title')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/staff/atc_all.apps')}}</span>
            <span class="info-box-number">{{ $appsCount }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/staff/atc_all.active_stu')}}</span>
            <span class="info-box-number">{{ $activeCount }}</span>
          </div>
        </div>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/staff/atc_all.new_apps')}}</span>
            <span class="info-box-number">N/A</span>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{__('app/admin/dashboard.members')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table
              id="atc_sessions_table"
              class="table table-bordered table-hover"
              data-order='[[ 2, "desc" ]]'>
              <thead>
              <tr>
                <th>{{__('app/staff/atc_all.cid')}}</th>
                <th>{{__('app/staff/atc_all.name')}}</th>
                <th>{{__('app/staff/atc_all.rating')}}</th>
                <th>{{__('app/staff/atc_all.region')}}</th>
                <th>{{__('app/staff/atc_all.airport')}}</th>
                <th>{{__('app/staff/atc_all.motiv')}}</th>
                <th>{{__('app/staff/atc_all.mentor')}}</th>
                <th>{{__('app/staff/atc_all.options')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($apps as $a)
                  <tr>
                    <td>{{ $a['user']['vatsim_id'] }}</td>
                    <td>{{ $a['user']['fname'] }} {{ $a['user']['lname'] }}</td>
                    <td>{{ $a['user']['atc_rating_short'] }}</td>
                    <td>{{ $a['user']['subdiv_id'] }} {{ $a['user']['subdiv_name'] }}</td>
                    <td>{{ $a['icao'] }}</td>
                    <td>
                      <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#motiv_modal_{{ $a['user']['vatsim_id'] }}">
                        {{__('app/staff/atc_all.motiv')}}
                      </button>
                    </td>
                    <td>
                      @if ($a['mentor_id'] == null)
                      {{__('app/staff/atc_all.no_mentor')}}
                      @else
                        {{ $a['mentor']['user']['fname'] }} {{ $a['mentor']['user']['lname'] }}
                      @endif
                    </td>
                    <td>
                      @if ($a['mentor_id'] == null)
                        @if (in_array($a['user']['atc_rating_short'], $choosable_ranks))
                          <form action="{{ route('app.staff.atc.all.take', app()->getLocale()) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $a['id'] }}" name="requestid">
                            <button type="submit" class="btn btn-block btn-success btn-flat">
                              {{__('app/staff/atc_all.take')}}
                            </button>
                          </form>
                        @else
                        {{__('app/staff/atc_all.rank_too_high')}}
                        @endif
                      @else
                      {{__('app/staff/atc_all.taken')}}
                      @endif
                    </td>
                  </tr>
                  <div class="modal fade" id="motiv_modal_{{ $a['user']['vatsim_id'] }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{__('app/staff/atc_all.motiv_title', ['FNAME' => $a['user']['fname']])}}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>{{ $a['motivation'] }}</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_all.motiv_close')}}</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $('#atc_sessions_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  </script>
@endsection