@component('mail::message')
# Bonjour {{ $user->fname }}!

Une nouvelle réservation a été enregistrée sur votre compte.

<b>Position:</b> {{ $data['position'] }}<br>
<b>Date:</b> {{ $data['date'] }}<br>
<b>Heure:</b> {{ $data['time'] }}<br>
<br>
Vous pouvez consulter et éditer vos réservations <a href="{{ route('app.atc.mybookings', 'fr') }}" target="_blank" rel="noopener noreferrer">ici</a>.
<br>

Merci,<br>
{{ config('app.name') }} le staff VatFrance
<br>
<br>
@if (!is_null($calendarLinks['ics']))
<div align="center">
  <a href="{{ $calendarLinks['google'] }}" class="button button-primary" target="_blank" rel="noopener">Ajouter au calendrier Google</a>
</div>
@endif

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
  Ce mail a été généré automatiquement.
  Si vous voulez ne plus en recevoir, vous pouvez éditer vos préférences ici :
  <a href="{{ route('app.user.settings', 'fr') }}" target="_blank" rel="noopener noreferrer">dans vos réglages utilisateur</a>.
@endcomponent
@endcomponent
