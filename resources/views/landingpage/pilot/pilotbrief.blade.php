@extends('layouts.landing')

@section('page-title')
  Pilotbrief
@endsection

@section('page-masthead')
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
  crossorigin="anonymous"
></script>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
  crossorigin="anonymous"
></script>
<script
  src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
  crossorigin="anonymous"
></script>
<section class="intro">
  <div class="container_ATC">
    <div class="row">
      <div class="col-md-12">
        <h1>Aerodrome Charts</h1>
      </div>
      <div class="col-md-12">
        <form class="formsearch" id="icaosearch" action="{{ route('landingpage.pilot.charts.fetch', app()->getLocale()) }}" method="POST">
          @csrf
          <input class="inputsearch" type="search" placeholder="LFPG" name="icao" />
          <i class="fa fa-search" id="btnicon"></i>
        </form>
      </div>
    </div>
  </div>
</section>
<script>
  var form = document.getElementById("icaosearch");

  document.getElementById("btnicon").addEventListener("click", function () {
    form.submit();
  });
</script>
@endsection

@section('page-content')
<div class="container-fluid">
  @if ($hasCharts)
    <iframe
      src="https://chartfox.org/api/interface/charts/LFMN?token=317CB5565DD1CC52B787F4113F6C3"
      frameborder="0"
      height="1200px"
      width="100%"
    ></iframe>
  @endif
</div>
@endsection