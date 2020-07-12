@extends('layouts.landing')

@section('pagetitle')
    Home
@endsection

@section('page-styling')
<style>
  .bg-transparent {
    transition: 0.75s ease;
  }

  .bg-transparent.scrolled {
    background: #092640 !important;
  }

  .bg-transparent {
    background-color: rgba(9, 38, 64, 0.59) !important;
  }
</style>
@endsection

@section('hero')
<section name="cartouche">
  <div class="bluediv"></div>

  <div class="training-banner">
    <img
      src="{{ asset('media/img/banner-atc.jpg') }}"
      class="img-fluid"
      alt="Responsive image"
    />
  </div>
</section>
@endsection

@section('content')
{{-- <section name="deveniratc">
  <div class="atc-fr">
    <h1>Devenir ATC virtuel ? C'est possible !</h1>

    <div class="section1-atc">
      <div class="description-atc">
        <p>Vous êtes tenté de découvrir une autre facette de la simulation ? Lassé du rôle de pilote ? Découvrez le rôle de contrôleur aérien virtuel !</p>
        <p>Les Procédures, les routes aériennes, les cartes, les SIDs, les STARs : elles n'auront plus de secrets pour vous.</p>
        <p>Vous approfondirez votre <b>connaissance de la phraséologie française et anglaise</b>.</p>
        <p>Vous pourrez participer aux <b>événements de VAT France</b> en tant que contrôleur</p>
        <p>L'occasion parfaite pour de <b>nouvelles expériences</b>, cette fois-ci du coté de l'écran radar.</p>
        <p>Cette fois-ci c'est vous le chef ! A votre tour d'<b>orchestrer votre fréquence d'une main de maitre</b> !</p>
      </div>

      <div class="legend-radar">
        <img class="radar" src="{{ asset('media/img/euroscope.jpg') }}" alt="">
        <h6>Aperçu du logiciel de contrôle Euroscope</h6>
      </div>
    </div>
  </div>
</section> --}}
<section name="deveniratc">
  <div class="atc-fr">
    <h1>Devenir ATC virtuel ? C'est possible !</h1>

    <div class="section1-atc">
      <div class="container-fluid" id="container">
        <p>
          Vous êtes tenté de découvrir une autre facette de la simulation ?
          Lassé du rôle de pilote ? Découvrez le rôle de contrôleur aérien
          virtuel !
        </p>
        <p>
          Les Procédures, les routes aériennes, les cartes, les SIDs, les
          STARs : elles n'auront plus de secrets pour vous.
        </p>
        <p>
          Vous approfondirez votre
          <b>connaissance de la phraséologie française et anglaise</b>.
        </p>
        <p>
          Vous pourrez participer aux <b>événements de VAT France</b> en
          tant que contrôleur
        </p>
        <p>
          L'occasion parfaite pour de <b>nouvelles expériences</b>, cette
          fois-ci du coté de l'écran radar.
        </p>
        <p>
          Cette fois-ci c'est vous le chef ! A votre tour d'<b
            >orchestrer votre fréquence d'une main de maitre</b
          >
          !
        </p>
      </div>
    </div>
  </div>
</section>
@endsection
