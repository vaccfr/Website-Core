@extends('layouts.app')

@section('page-title', 'Home')

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Home page</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Home</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">
      Example card I can work with rn
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      Card footer (if needed)
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
@endsection