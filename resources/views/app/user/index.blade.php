@extends('layouts.app')

@section('page-title')
  Home | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/user/index.welcomeback')}}, {{ Auth::user()->fname }}!</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('app.user.settings', app()->getLocale()) }}">{{__('app/app_menus.my_settings')}}</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user elevation-3">
          <div class="widget-user-header text-white" style="background-color: #17a2b8;">
            <h3 class="widget-user-username">{{ Auth::user()->fullname() }}</h3>
            <h5 class="widget-user-desc">{{ Auth::user()->account_type }}</h5>
            <div class="widget-user-image">
              <img class="img-circle elevation-3" src="{{ asset('media/img/dashboard/default_upp.png') }}" alt="User Avatar">
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">Vatsim ID</span>
                  <h5 class="description-header">{{ Auth::user()->vatsim_id }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">{{__('app/user/index.atc_rank')}}</span>
                  <h5 class="description-header">{{ Auth::user()->fullAtcRank() }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <span class="description-text">{{__('app/user/index.pilot_rank')}}</span>
                  <h5 class="description-header">P{{ Auth::user()->pilot_rating }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3">
                <div class="description-block">
                  <span class="description-text">{{__('app/user/index.approved_atc')}}</span>
                  <h5 class="description-header">@if (Auth::user()->isApprovedAtc() == true)
                    {{__('app/user/index.approved')}}
                  @else
                    {{__('app/user/index.not_approved')}}
                  @endif</h5>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card card-info elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/user/index.ev_title')}}</h3>
          </div>
        </div>
        <div class="card elevation-0" style="background-color: #f8f9fa;">
          <div class="card-body p-0">
            @forelse ($events as $e)
            <div class="card elevation-3">
              <div class="card-header">
                <h3 class="card-title">{{$e['title']}}</h3>
                <span class="float-right">
                  {{$e['date']}} | {{$e['start_time']}} - {{$e['end_time']}}
                </span>
              </div>
              <div class="card-body" style="padding: 0 0 0 0;">
                <img class="img-fluid pad" src="@if ($e['has_image'] == true)
                {{config('app.url')}}/{{$e['image_url']}}
            @else
                {{asset('media/img/placeholders/events_placeholder_noimg.png')}}
            @endif" alt="Placeholder">
              </div>
              <div class="card-footer">
                {{$e['description']}}
              </div>
            </div>
            @empty
            <div class="card elevation-3">
              <div class="card-header">
                <h3 class="card-title"><i>{{__('app/user/index.ev_noevents')}}</i></h3>
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-info elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/user/index.n_title')}}</h3>
          </div>
        </div>
        <div class="card elevation-0" style="background-color: #f8f9fa;">
          <div class="card-body p-0">
            @forelse ($news as $n)
            <div class="card elevation-3">
              <div class="card-header">
                <h3 class="card-title">Titre de mon annonce!</h3>
                <span class="float-right">
                  Date - Heure
                </span>
              </div>
              <div class="card-body">
                Généralement, on utilise un texte en faux latin (le texte ne veut rien dire, il a été modifié),
                le Lorem ipsum ou Lipsum, qui permet donc de faire office de texte d'attente.
                L'avantage de le mettre en latin est que l'opérateur sait au premier coup d'oeil que la page contenant ces lignes n'est pas valide,
                et surtout l'attention du client n'est pas dérangée par le contenu, il demeure concentré seulement sur l'aspect graphique.
              </div>
            </div>
            @empty
            <div class="card elevation-3">
              <div class="card-header">
                <h3 class="card-title"><i>{{__('app/user/index.n_nonews')}}</i></h3>
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-info elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/user/index.b_title')}}</h3>
          </div>
        </div>
        <div class="card elevation-3">
          @if (count($bookings) == 0)
          <div class="card-header">
            <h3 class="card-title"><i>{{__('app/user/index.b_nobook')}}</i></h6>
          </div>
          @else
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="width: 30%;">{{__('app/user/index.b_pos')}}</th>
                  <th style="width: 20%;">{{__('app/user/index.b_time')}}</th>
                  <th style="width: 50%;">{{__('app/user/index.b_who')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bookings as $b)
                <tr>
                  <td>{{$b['position']}}</th>
                  <td>{{$b['time']}}</td>
                  <td>{{$b['user']['fname']}} {{$b['user']['lname']}} - {{$b['user']['atc_rating_short']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
        </div>
      </div>

    </div>
  </div>
@endsection