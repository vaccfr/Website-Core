@extends('layouts.app')

@section('page-title')
  Staff organisation
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Staff Organisation</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<style>
  .center-block {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
</style>
<link rel="stylesheet" href="{{ asset('dashboard/orgchart.css') }}">

<div class="container-fluid">
  <div id="staff-tree"></div>
</div>

<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('dashboard/orgchart.js') }}"></script>
<script>
  $(document).ready(function(){
    $.ajax({
    dataType: "json",
    url: "{{ asset('assets/staff.json') }}"}).done( function( data ) {
      OrgTree.setOptions(
        {
          baseLevel: 12,
          minWidth: 2,
          collapsable: true,
          renderNode: function(node) {
            return `<div class="node center-block text-center" style="background-color: ${node.color}; color: ${node.text};">
                              <strong>${node.name}</strong><br />
                              <em>${node.label}</em>
                          </div>`
          }
        }
      );
      OrgTree.makeOrgTree($('#staff-tree'), data);
    });
  });
</script>
@endsection