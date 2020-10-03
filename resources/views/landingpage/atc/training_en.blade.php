@extends('layouts.landing')

@section('page-title')
  ATC Training
@endsection

@section('page-masthead')
<section class="intro">
  <div class="container_ATC">
    <h1>Become ATC &darr;</h1>
  </div>
</section>
@endsection

@section('page-content')
<section class="timeline">
  <ul>
    <li>
      <div class="ATC_TEXT">
        <time>First Steps</time>
        To start your ATC Training with the French vACC, you must first create a VATSIM account.
        You can then use this account to <a class="lol" href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" target="_blank" rel="noopener noreferrer">
          log into your account</a> and request your mentoring.
      </div>
    </li>
    <li>
        <div class="ATC_TEXT">
          <time>Initial Session</time>
          Before you can start your training, you must first complete the initial information session. This session is organised once a month by our training staff
          and takes place on our teamspeak server. 
          During this session, you will learn basic information about the network and its organisation from an ATC perspective, and also how to use the main ATC tools.<br>
          Some mentors are allowed to teach the contents of this information session alone, allowing you to start training right away.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Observation</time>
          Before any concrete teaching takes place, you must complete at least 20 hours of observation time on the network.
          This is accomplished using the tools you have been introduced to over the previous sessions.
          The purpose of this observation time is for you to get acquainted with the network and the tools on your own, and get a better understanding of the processes which take place on the ATC side.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Training</time>
          Your mentor will guide you, in most cases, throughout your entire ATC career in the French vACC - or up to the level they are allowed to teach. <br>
          <b>Training can last between a few weeks to a few months for every single rank</b>. This time is necessary to guarantee the highest standard of teaching
          and to ensure you will provide the highest possible quality service with the best confidence.
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>ATC Ranks Explained</time>
          VATSIM ATCOs are awarded ratings based on their knowledge and progression.
          These ranks are obtained through thorough teaching, learning and examination flows. <br>
          The following ranks are available: <br>
          - <b>S1</b> -> Student ATC 1, allowed (on authorisation) to control DEL and GND positions <br>
          - <b>S2</b> -> Student ATC 2, allowed (on authorisation) to control TWR and below positions <br>
          - <b>S3</b> -> Student ATC 3, allowed (on authorisation) to control APP, DEP and below positions <br>
          - <b>C1</b> -> Controller 1, allowed to control CTR, FSS and below positions <br>
          - <b>C3</b> -> Controller 3, a seniority rank with no further privileges. <br>
          <br>
          <i>n.b.: some positions, airfields etc. may be restricted to ATCs based on various criteria. Please refer to staff for any questions.</i>
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Examination & Progression Flow</time>
          For every single rank from S1 to C1, the training is structured as follows: <br>
          - Introductory session covering general and detailed concepts of the position <br>
          - Preparation for theory exam <br>
          - Theory exam <br>
          - Assuming successful exam, start of the practical learning via simulation sessions <br>
          - Following these sessions, the student will start training online with real VATSIM pilots <br>
          - Once the student is deemed ready, they will take the practical exam (CPT) <br>
          - If successful, the student is awarded the new rating <br>
          <br>
          <i>n.b.: S1 are exempt from CPT and C3/i1/i3 are exempt from theory exams.</i>
        </div>
      </li>
      <li>
        <div class="ATC_TEXT">
          <time>Are you ready to take on the challenge?</time>
          <a class="lol" href="https://www.vatsim.net/join" target="_blank">Create your account</a>  today with VATSIM, then 
          <a class="lol" href="{{ route('auth.login', ['locale' => app()->getLocale(), 'redirflag' => 'false']) }}" target="_blank" rel="noopener noreferrer">
            click here
          </a> to connect to your French vACC account! <br>
          Other links: <br>
          - Our <a class="lol" href="{{ route('discord.invite') }}" target="_blank">Discord Server</a> <br>
        </div>
      </li>
  </ul>
</section>
@endsection