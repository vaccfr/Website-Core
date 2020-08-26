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
        <form class="formsearch" action="">
          <input class="inputsearch" type="search" placeholder="LFPG" />
          <i class="fa fa-search"></i>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('page-content')
<div class="card chartcard shadow">
  <a
    data-toggle="collapse"
    data-target="#drop"
    class="card-block stretched-link text-decoration-none"
    href="#"
  ></a>
  <h3>LFPG / Paris Charles de Gaulle</h3>
</div>
<div id="drop" class="collapse table-responsive">
  <table class="table table-charts table-borderless mx-auto w-auto">
    <thead>
      <tr>
        <th scope="col">Effective date</th>
        <th scope="col">Name</th>
        <th scope="col">Link</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row ">10 SEP 2020</th>
        <td>OACI</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>IAC</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>SID STAR</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="card chartcard shadow">
  <a
    data-toggle="collapse"
    data-target="#drop2"
    class="card-block stretched-link text-decoration-none"
    href="#"
  ></a>
  <h3>LFMN / Nice Côte d'Azur</h3>
</div>
<div id="drop2" class="collapse table-responsive">
  <table class="table table-charts table-borderless mx-auto w-auto">
    <thead>
      <tr>
        <th scope="col">Effective date</th>
        <th scope="col">Name</th>
        <th scope="col">Link</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row ">10 SEP 2020</th>
        <td>OACI</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>IAC</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>SID STAR</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="card chartcard shadow">
  <a
    data-toggle="collapse"
    data-target="#drop3"
    class="card-block stretched-link text-decoration-none"
    href="#"
  ></a>
  <h3>LFSB / EuroAirport Basel Mulhouse Freiburg</h3>
</div>
<div id="drop3" class="collapse table-responsive">
  <table class="table table-charts table-borderless mx-auto w-auto">
    <thead>
      <tr>
        <th scope="col">Effective date</th>
        <th scope="col">Name</th>
        <th scope="col">Link</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row ">10 SEP 2020</th>
        <td>OACI</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>IAC</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
      <tr>
        <th scope="row">10 SEP 2020</th>
        <td>SID STAR</td>
        <td>
          <a href="#"><i class="fas fa-download"></i></a>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection