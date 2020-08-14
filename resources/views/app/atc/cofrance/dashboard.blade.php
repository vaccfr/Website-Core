{{-- This page is a template for other webapp pages --}}

@extends('layouts.app')

@section('page-title')
  CoFrance | Dashboard
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>CoFrance Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title">Request Token</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('app.atc.cofrance.newtoken', app()->getLocale()) }}" method="post">
            @csrf
            <label for="unique">Define Password</label>
            <div class="input-group input-group-sm">
              <input class="form-control" type="password" name="unique" id="unique" placeholder="Password" required>
              <span class="input-group-append">
                <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                <button type="submit" class="btn btn-success btn-flat btn-block">Submit</button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection