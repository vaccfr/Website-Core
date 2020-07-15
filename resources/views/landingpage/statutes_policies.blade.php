@extends('layouts.landing')

@section('page-title')
  Statutes & Policies
@endsection

@section('page-masthead')
<header class="masthead text-center text-white">
  <div class="masthead-content">
    <div class="container bg-overlay">
      <h1 class="masthead-heading mb-2 mt-5">Our Statutes & Policies</h1>
      <h2 class="masthead-subheading mb-2"></h2>
    </div>
  </div>
</header>
@endsection

@section('page-content')
  <!-- Page Content -->
<section class="py-5">
  <div class="card text-center">
    <div class="card-header">
      <ul
        class="nav nav-tabs card-header-tabs"
        id="bologna-list"
        role="tablist"
      >
        <li class="nav-item">
          <a
            class="nav-link active"
            href="#Privacy-Policy"
            data-toggle="tab"
            >Privacy Policy</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            href="#Policies"
            data-toggle="tab"
            >Policies</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            href="#Statutes"
            data-toggle="tab"
            >Statutes</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            href="#Notams"
            data-toggle="tab"
            >Notams</a
          >
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content mt-3">
        <div class="tab-pane active" id="Privacy-Policy" role="tabpanel">
          <p class="card-text">
            @include('policies.privacy')
          </p>
        </div>

        <div class="tab-pane" id="Policies" role="tabpanel">
          <p class="card-text">
            TBA
          </p>
        </div>

        <div
          class="tab-pane"
          id="Statutes"
          role="tabpanel"
        >
          <p class="card-text">
            TBA
          </p>
        </div>

        <div
          class="tab-pane"
          id="Notams"
          role="tabpanel"
        >
          <p class="card-text">
            TBA
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection