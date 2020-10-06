@component('mail::message')
# Nouvelle requête reçue sur le site

### Question de {{$user->fname}} {{$user->lname}} ({{$user->vatsim_id}}):
@component('mail::panel')
{!! nl2br($question) !!}
@endcomponent

@component('mail::button', ['url' => route('app.staff.cofbmanager', 'fr')])
Voir ou Répondre à ce message
@endcomponent

Merci,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  Cet email vous a été envoyé automatiquement car vous faites partie du Staff.
@endcomponent
@endcomponent
