@extends('layouts.app')

@section('page-title')
  All ATC Bookings | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/atc/atc_allbookings.header_title')}}</h1>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('page-content')
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark card-tabs elevation-3">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              @foreach ($bookingDate as $bdate)
              <li class="nav-item">
                <a
                  class="nav-link @if ($loop->index == 0) active @endif" 
                  id="booking_day_{{ $loop->index }}"
                  data-toggle="pill"
                  href="#booking_day_tab_{{ $loop->index }}"
                  role="tab"
                  aria-controls="booking_day_tab_{{ $loop->index }}"
                  aria-selected="true">{{ $bdate }}</a>
              </li>
              @endforeach
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="bookings-tables">
              @foreach ($bookings as $book)
              <div class="tab-pane fade show @if ($loop->index == 0) active @endif" id="booking_day_tab_{{ $loop->index }}" role="tabpanel" aria-labelledby="booking_day_{{ $loop->index }}">
                <h3>{{__('app/atc/atc_allbookings.bookings_for', ['DATE' => $bookingDate[$loop->index]])}}</h3>
                <table
                  id="booking_table_{{ $loop->index }}"
                  class="table table-hover mt-3"
                  data-order='[[ 2, "asc" ]]'>
                  <thead>
                  <tr>
                    <th>{{__('app/atc/atc_allbookings.position')}}</th>
                    <th>{{__('app/atc/atc_allbookings.name')}}</th>
                    <th>{{__('app/atc/atc_allbookings.hours')}}</th>
                    <th>{{__('app/atc/atc_allbookings.rating')}}</th>
                    <th>{{__('app/atc/atc_allbookings.mentoring')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($book as $b)
                      <tr>
                        <td>{{$b['position']}}</td>
                        <td>{{$b['user']['fname']}} {{$b['user']['lname']}} ({{$b['vatsim_id']}})</td>
                        <td>{{date_create_from_format('Y-m-d H:i:s', $b['start_date'])->format('H:i')}}z - {{date_create_from_format('Y-m-d H:i:s', $b['end_date'])->format('H:i')}}z</td>
                        <td>{{$b['user']['atc_rating_short']}}</td>
                        <td>@if ($b['training'] == true)
                          <span class="badge bg-success"><i class="fa fa-check"></i> {{__('app/global.yes')}}</span>
                        @else
                          <span class="badge bg-danger"><i class="fa fa-times"></i> {{__('app/global.no')}}</span>
                        @endif</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <script>
                $('#booking_table_{{ $loop->index }}').DataTable({
                  "paging": false,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": false,
                  "autoWidth": false,
                  "responsive": true,
                  "language": {
                    "emptyTable": "{{__('app/atc/atc_allbookings.no_bookings')}}"
                  }
                });
              </script>
              @endforeach
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
@endsection