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
    <div class="col-md-4">
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title">Request Token</h3>
        </div>
        <div class="card-body">
          @if (!is_null($token))
            <div class="form-group">
              <label for="currtoken">Current Token</label>
              <input class="form-control" name="currtoken" value="{{$token}}" disabled>
            </div>
          @endif
          <form class="mt-2" action="{{ route('app.atc.cofrance.newtoken', app()->getLocale()) }}" method="post">
            @csrf
            <input type="hidden" name="userid" value="{{Auth::user()->id}}">
            <button type="submit" class="btn btn-success btn-flat">Generate new Token</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title">Config Editor</h3>
        </div>
        <form action="{{ route('app.atc.cofrance.storeconfig', app()->getLocale()) }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="editor">Editor</label>
              <textarea class="form-control" name="editor" id="editor" rows="20">{{$editorContent}}</textarea>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success btn-flat">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection