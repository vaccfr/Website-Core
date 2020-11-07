{{-- This page is a template for other webapp pages --}}

@extends('layouts.app')

@section('page-title')
  URL Shortener
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>URL Shortener</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">
      <div class="card card-dark card-outline elevation-3">
        <div class="card-body p-0">
          <table class="table">
            <tbody>
              <tr>
                <td>
                  <button class="btn btn-block btn-success" data-toggle="modal" data-target="#new_url">New URL</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div id="new_url" class="modal fade">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">New URL</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('app.staff.urlshortener.make', app()->getLocale())}}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="newshort">URL to shorten</label>
                  <input type="text" class="form-control" id="newurl" name="newurl">
                </div>
                <div class="form-group">
                  <label for="newshort">Shortened to:</label>
                  <input type="text" class="form-control" id="newshort" name="newshort">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                <button type="submit" class="btn btn-success">Create URL</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">URLs</h3>
        </div>
        <div class="card-body">
          <table
            id="urltable"
            class="table table-bordered table-hover"
            data-order="[[ 0, 'asc' ]]">
            <thead>
              <tr>
                <th>Final URL</th>
                <th>Short</th>
                <th>Target URL</th>
                <th>Author</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($urls as $u)
              <tr>
                <td><a href="{{config('app.url')}}/r/{{$u['short']}}" target="_blank">{{config('app.url')}}/r/{{$u['short']}}</a></td>
                <td>{{$u['short']}}</td>
                <td><a href="{{$u['url']}}" target="_blank">{{$u['url']}}</a></td>
                <td>{{$u['author']['fname']}} {{$u['author']['lname']}} ({{$u['author']['vatsim_id']}})</td>
                <td>
                  <div class="row">
                    <div class="col-md-6">
                      <button
                        type="button"
                        class="btn btn-success btn-block elevation-1"
                        data-toggle="modal"
                        data-target="#editor-{{$loop->index}}"
                      >
                        Edit URL
                      </button>
                    </div>
                    <div class="col-md-6">
                      <button
                        type="button"
                        class="btn btn-danger btn-block elevation-1"
                        data-toggle="modal"
                        data-target="#delete-{{$loop->index}}"
                      >
                        Delete URL
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
              <div id="editor-{{$loop->index}}" class="modal fade">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit URL</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{route('app.staff.urlshortener.edit', app()->getLocale())}}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="newshort">URL to shorten</label>
                          <input type="text" class="form-control" id="newurl" name="newurl" value="{{$u['url']}}">
                        </div>
                        <div class="form-group">
                          <label for="newshort">Shortened to:</label>
                          <input type="text" class="form-control" id="newshort" name="newshort" value="{{$u['short']}}">
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="shortid" value="{{$u['id']}}">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                        <button type="submit" class="btn btn-success">Modify URL</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="delete-{{$loop->index}}" class="modal fade">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete URL</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{route('app.staff.urlshortener.delete', app()->getLocale())}}" method="post">
                      @csrf
                      <div class="modal-body">
                        Are you sure you want to delete this URL? This action cannot be undone.
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="shortid" value="{{$u['id']}}">
                        <button type="submit" class="btn btn-danger">Delete URL</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/atc/atc_training_center.close')}}</button>
                      </div>
                    </form>
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
  $("#urltable").DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "autoWidth": true,
    "info": true,
  });
</script>
@endsection