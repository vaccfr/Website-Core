@extends('layouts.app')

@section('page-title')
  ATC Roster | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ATC Rosters</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-secondary card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link active" 
                id="atc-roster-tab"
                data-toggle="pill"
                href="#atc-roster"
                role="tab"
                aria-controls="atc-roster"
                aria-selected="true">ATC Roster</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link" 
                id="atc-mentors-tab"
                data-toggle="pill"
                href="#atc-mentors"
                role="tab"
                aria-controls="atc-mentors"
                aria-selected="false">ATC Mentors</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link" 
                id="solo-approval-tab"
                data-toggle="pill"
                href="#solo-approval"
                role="tab"
                aria-controls="solo-approval"
                aria-selected="false">Solo Approvals</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link" 
                id="domtom-approval-tab"
                data-toggle="pill"
                href="#domtom-approval"
                role="tab"
                aria-controls="domtom-approval"
                aria-selected="false">DOM/TOM Approval</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="atc-rosters-tables">
            <div class="tab-pane fade show active" id="atc-roster" role="tabpanel" aria-labelledby="atc-roster-tab">
              <table
                id="atc_roster"
                class="table table-bordered table-hover"
                data-order='[[ 1, "desc" ]]'>
                <thead>
                <tr>
                  <th>CID</th>
                  <th>Name</th>
                  <th>Rating</th>
                  <th>Approved</th>
                  <th>Authorised LFPG TWR</th>
                  <th>Authorised LFPG APP</th>
                  <th>Authorised LFMN TWR</th>
                  <th>Authorised LFMN APP</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    @foreach ($atc_roster as $atc)
                    <td>{{ $atc['user']['vatsim_id'] }}</td>
                    @if ($atc['user']['hide_details'] == false)
                    <td>{{ $atc['user']['fname'] }} {{ $atc['user']['lname'] }}</td>
                    @else
                    <td><i>Hidden</i></td>
                    @endif
                    <td>{{ $atc['user']['atc_rating_short'] }}</td>
                    <td>
                      @if ($atc['approved_flag'] == true)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    <td>
                      @if ($atc['appr_lfpg_twr'] == true)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    <td>
                      @if ($atc['appr_lfpg_app'] == true)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    <td>
                      @if ($atc['appr_lfmn_twr'] == true)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    <td>
                      @if ($atc['appr_lfmn_app'] == true)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="atc-mentors" role="tabpanel" aria-labelledby="atc-mentors-tab">
               Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
            </div>
            <div class="tab-pane fade" id="solo-approval" role="tabpanel" aria-labelledby="solo-approval-tab">
               Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
            </div>
            <div class="tab-pane fade" id="domtom-approval" role="tabpanel" aria-labelledby="domtom-approval-tab">
               Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
  $('#atc_roster').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "autoWidth": true,
    "info": true,
    "scrollY": 300,
  });
</script>
@endsection