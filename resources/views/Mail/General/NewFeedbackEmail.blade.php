@component('mail::message')
# Nouveau feedback reçu pour {{$user->fname}} {{$user->lname}} ({{$user->vatsim_id}})

<b>Envoyé par:</b> {{$sender->fname}} {{$sender->lname}} ({{$sender->vatsim_id}}) <br>
<b>Position:</b> {{ $data['position'] }} <br>
<b>Date et Heure approximatives (UTC):</b> {{ $data['datetime'] }} <br>
@component('mail::panel')
{!! nl2br($data['msg']) !!}
@endcomponent

Merci,<br>
{{ config('app.name') }}

@component('mail::subcopy')
  Cet email vous a été envoyé automatiquement car vous en faites l'objet, ou car vous faites partie du Staff.
@endcomponent
@endcomponent
