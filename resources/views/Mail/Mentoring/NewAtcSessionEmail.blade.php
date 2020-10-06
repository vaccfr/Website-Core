@component('mail::message')
# Centre de formation VatFrance

Nouvelle demande de session de votre mentor {{ $data['mentor_fname'] }} <br>

<b>Position:</b> {{ $data['position'] }} <br>
<b>Date:</b> {{ $data['date'] }} <br>
<b>Heure (UTC):</b> {{ $data['time'] }} <br>

@component('mail::button', ['url' => route('app.atc.training', app()->getLocale())])
Accepter / Refuser
@endcomponent

Merci,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
  This email was generated automatically.
  Si vous souhaitez ne plus en recevoir, vous pouvez éditer vos préférences
  <a href="{{ route('app.user.settings', 'fr') }}" target="_blank" rel="noopener noreferrer">dans vos réglages utilisateur</a>.
@endcomponent
@endcomponent
