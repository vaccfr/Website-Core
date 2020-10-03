@extends('layouts.landing')

@section('page-title')
  ATC Training
@endsection

@section('page-masthead')
<section class="intro">
  <div class="container_ATC">
    <h1>Devenir contrôleur &darr;</h1>
  </div>
</section>
@endsection

@section('page-content')
<section class="timeline">
  <ul>
    <li>
      <div class="ATC_TEXT">
        <time>Premiers pas</time>
        Pour devenir ATC dans la vACC France,vous devez d'abord vous crééer un compte VATSIM.
        Vous pourrez alors utiliser ce compte <a class="lol" href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" target="_blank" rel="noopener noreferrer">
          pour vous connecter</a> et faire votre demande de mentoring.
      </div>
    </li>
    <li>
        <div class="ATC_TEXT">
          <time>Session d'information</time>
          Avant de commencer votre formation de contrôleur aérien virtuel, vous devez assister à une session d'information. Celle-ci est organisée une fois par mois par nos mentors
          et a lieu sur notre serveur teamspeak. 
          Pendant cette session, vous apprendrez les informations essentielles sur le réseau VATSIM, surtout son organisation du point de vue ATC mais aussi les outils que vous utiliserez pour votre formation.<br>
          Certains mentors sont habilités à vous fournir ces informations d'eux-mêmes ce qui vous permettra de débuter votre formation de suite après.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Observation</time>
          Avant de passer réellement à la pratique, vous devrez réaliser 20 heures d'observation sur le réseau.
          Il s'agira pour vous de vous connecter sur le logiciel utilisé en tant que contrôleur pour observer vos futures actions.
          L'objectif de ce temps d'observation est de vous permettre de vous familiariser avec le réseau et les outils par vous-même, et de mieux comprendre les processus qui se déroulent du côté ATC.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Training</time>
          Le mentor qui vous aura été assigné vous suivra tout le long de votre carrière contrôleur de la vACC France - ou jusqu'au niveau auquel il est apte de vous former. <br>
          <b>La durée d'une formation est variable : ceci peu aller de quelques semaines à quelques mois.</b>. Ce temps est nécessaire pour garantir les meilleurs standards de formation
          et pour nous assurer que vous pourrez proposer le meilleur service de contrôle possible.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Grades contrôleurs</time>
          VATSIM reconnait les membres en leur délivrant des grades. Ces derniers témoignent uniquement de leurs connaissances et de leur progression.
          Ces grades sont obtenus après plusieurs heures de formation, pratique, apprentissage et examens pour vérifier vos compétences. <br>
          Voici ces grades: <br>
          - <b>S1</b> -> Student ATC 1, permet (sur autorisation) de contrôler les positions DEL et GND <br>
          - <b>S2</b> -> Student ATC 2, permet (sur autorisation) de contrôler les TWR et les positions précédentes <br>
          - <b>S3</b> -> Student ATC 3, permet (sur autorisation) de contrôler APP, DEP et les positions précédentes <br>
          - <b>C1</b> -> Controller 1, permet de contrôler les CTR, FSS et positions inférieures <br>
          - <b>C3</b> -> Controller 3, un grade senior reconnaissant vos compétences, pas de privilèges particuliers. <br>
          <br>
          <i>n.b.: certaines positions, terrains etc peuvent être restreints aux ATCs ou soumis à une formation supplémentaire. Vous pouvez vous référer au staff pour plus de renseignements.</i>
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Examens & Progression dans le cursus</time>
          Pour chacun des grades du S1 au C1, la formation est structurée comme suit: <br>
          - Session d'introduction vous expliquant les informations de bases nécessaires pour suivre le cursus <br>
          - Préparation à l'examen théorique <br>
          - Examen théorique <br>
          - Après réussite de l'examen, début des sessions de simulation <br>
          - Après ces quelques sessions, l'élève commencera la pratique en réseau, avec les pilotes connectés sur VATSIM <br>
          - Quand l'élève est prêt, le mentor demande l'examen pratique (CPT) pour son élève<br>
          - Si réussite, l'élève est promu au nouveau grade <br>
          <br>
          <i>n.b.: Le S1 est exempté de CPT et les C3/I1/I3 sont exemptés d'examens théoriques.</i>
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Etes vous prêts à relever le défi ?</time>
          <a class="lol" href="https://www.vatsim.net/join" target="_blank">Créez votre compte</a>  aujourd'hui avec VATSIM
          <a class="lol" href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" target="_blank" rel="noopener noreferrer">
            cliquez ici
          </a> pour vous connecter sur votre compte vACC France <br>
          Autres liens <br>
          - Notre <a class="lol" href="{{ route('discord.invite') }}" target="_blank">serveur Discord</a> <br>
        </div>
      </li>
  </ul>
</section>
@endsection