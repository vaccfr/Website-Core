@extends('layouts.app')

@section('page-title')
  Admin | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/admin/dashboard.header_title')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/admin/dashboard.members')}}</span>
            <span class="info-box-number">{{ $memberCount }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-headphones"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/admin/dashboard.atc_members')}}</span>
            <span class="info-box-number">{{ $atcCount }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/admin/dashboard.atc_book_tod')}}</span>
            <span class="info-box-number">{{ $bookingsCount }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- /.card -->
        <div class="card card-dark elevation-3">
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
                <th>{{__('app/admin/dashboard.name')}}</th>
                <th>{{__('app/admin/dashboard.cid')}}</th>
                <th>{{__('app/admin/dashboard.region')}}</th>
                <th>{{__('app/admin/dashboard.account')}}</th>
                <th>{{__('app/admin/dashboard.staff')}}</th>
                <th>{{__('app/admin/dashboard.atc_approv')}}</th>
                <th>{{__('app/admin/dashboard.linked_discord')}}</th>
                <th>{{__('app/admin/dashboard.atc_rank')}}</th>
                <th>{{__('app/admin/dashboard.pil_rank')}}</th>
                <th>{{__('app/admin/dashboard.last_login')}}</th>
                @if (Auth::user()->isAdmin()) <th>Beta Tester</th> @endif
                <th>{{__('app/admin/dashboard.actions')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($members as $m)
                  <tr>
                    <td>{{ $m['fname'] }} {{ $m['lname'] }}</td>
                    <td>{{ $m['vatsim_id'] }}</td>
                    <td>{{ $m['subdiv_id'] }} ({{ $m['subdiv_name'] }})</td>
                    <td>{{ $m['account_type'] }}</td>
                    <td>
                      @if($m['is_staff'] == true)
                        <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                        <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                      @endif
                    </td>
                    <td>
                      @if($m->isApprovedAtc() == true)
                        <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                        <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                      @endif
                    </td>
                    <td>
                      @if($m['linked_discord'] == true)
                        <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                        <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                      @endif
                    </td>
                    <td>{{ $m['atc_rating_short'] }}</td>
                    <td>P{{ $m['pilot_rating'] }}</td>
                    <td>{{ $m['last_login'] }}</td>
                    @if (Auth::user()->isAdmin())
                    <td>
                      @if($m['is_betatester'] == true)
                        <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                      @else
                        <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                      @endif
                    </td> 
                    @endif
                    <td>
                      <div class="row">
                        <div class="col-sm-6">
                          <form action="{{ route('app.staff.admin.edit', ['locale' => app()->getLocale()]) }}" method="get">
                            <input type="hidden" value="{{ $m['vatsim_id'] }}" name="cid">
                            <button type="submit" class="btn btn-block btn-info btn-flat">
                              {{__('app/admin/dashboard.edit')}}
                            </button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          @if (is_null($m['ban']))
                          <form action="{{ route('app.staff.block.add', ['locale' => app()->getLocale()]) }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $m['vatsim_id'] }}" name="cid">
                            <button type="submit" class="btn btn-block btn-warning btn-flat">
                              {{__('app/admin/dashboard.restrict')}}
                            </button>
                          </form>
                          @else
                          <form action="{{ route('app.staff.block.remove', ['locale' => app()->getLocale()]) }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $m['vatsim_id'] }}" name="cid">
                            <button type="submit" class="btn btn-block btn-success btn-flat">
                              {{__('app/admin/dashboard.unrestrict')}}
                            </button>
                          </form>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
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