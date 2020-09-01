{{-- This page is a template for other webapp pages --}}

@extends('layouts.app')

@section('page-title')
  Contact Manager
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestionnaire Contacts & Feedbacks</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-5">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">Contact</h3>
        </div>
        <div class="card-body">
          <table
            id="contact_requests"
            class="table table-hover"
            data-order='[[ 1, "desc" ]]'>
            <thead>
            <tr>
              <th>Qui</th>
              <th>Voir Message</th>
              <th>Répondre</th>
              <th>Statut</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($contacts as $c)
              <tr>
                <td>{{$c['name']}} ({{$c['vatsim_id']}})</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info btn-flat"
                    data-toggle="modal"
                    data-target="#read_msg_{{$c['id']}}"
                    ><i class="fa fa-eye"></i>
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info btn-flat"
                    @if ($c['responded'] == false)
                    data-toggle="modal"
                    data-target="#respond_{{$c['id']}}"
                    @else
                    disabled
                    @endif
                    ><i class="fa fa-pen"></i>
                  </button>
                </td>
                <td>
                  @if ($c['responded'] == true)
                    <span class="badge bg-success"><i class="fa fa-check"></i> Répondu</span>
                  @else
                    <span class="badge bg-warning"><i class="fa fa-question"></i> En attente</span>
                  @endif
                </td>
              </tr>
              <div class="modal fade" id="read_msg_{{$c['id']}}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Message de {{$c['name']}} ({{$c['vatsim_id']}}) - Reçu le {{date_create_from_format('Y-m-d H:i:s', $c['created_at'])->format('Y.m.d (H:i)')}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>{!! nl2br($c['message']) !!}</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.close')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              @if ($c['responded'] == false)
              <div class="modal fade" id="respond_{{$c['id']}}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Répondre à {{$c['name']}} ({{$c['vatsim_id']}})</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.staff.cofbmanager.corespond', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="msgbody">{{__('app/staff/atc_mine.spmm_msg')}}</label>
                          <textarea class="form-control" rows="15" name="msgbody" id="msgbody" placeholder="{{__('app/staff/atc_mine.spmm_your_msg')}}"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="id" value="{{$c['id']}}">
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.close')}}</button>
                        <button type="submit" class="btn btn-success">{{__('app/staff/atc_mine.spmm_sendmsg')}}</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">ATC Feedback</h3>
        </div>
        <div class="card-body">
          <table
            id="atc_feedback"
            class="table table-hover"
            data-order='[[ 1, "desc" ]]'>
            <thead>
            <tr>
              <th>Qui</th>
              <th>Adressé à</th>
              <th>Date & Position</th>
              <th>Voir Message</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($atcFeedback as $f)
              <tr>
                <td>{{$f['name']}} ({{$f['vatsim_id']}})</td>
                <td>{{$f['target']['fname']}} {{$f['target']['lname']}} ({{$f['controller_cid']}})</td>
                <td>{{date_create_from_format('Y-m-d H:i:s', $f['occurence_date'])->format('Y.m.d (H:i)')}} - {{$f['position']}}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info btn-flat"
                    data-toggle="modal"
                    data-target="#read_msg_{{$f['id']}}"
                    ><i class="fa fa-eye"></i>
                  </button>
                </td>
              </tr>
              <div class="modal fade" id="read_msg_{{$f['id']}}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Feedback de {{$f['name']}} ({{$f['vatsim_id']}}) - Reçu le {{date_create_from_format('Y-m-d H:i:s', $f['created_at'])->format('Y.m.d (H:i)')}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>{!! nl2br($f['message']) !!}</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/atc_mine.close')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>
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
  $("#contact_requests").DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "autoWidth": false,
    "info": false,
    "language": {
      "emptyTable": "Pas de demandes trouvées"
    }
  });
  $("#atc_feedback").DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "autoWidth": false,
    "info": false,
    "language": {
      "emptyTable": "Pas de feedbacks ATC trouvés"
    }
  });
</script>
@endsection