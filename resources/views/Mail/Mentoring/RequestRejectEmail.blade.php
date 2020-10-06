@component('mail::message')
# Demande de Mentoring ATC rejetée

<b>Demandeur: </b> {{ $data['student'] }}<br>
<b>Rejeté par: </b> {{ $data['rejector'] }}<br>
<b>Justification: </b><br>
@component('mail::panel')
{!! $data['body'] !!}
@endcomponent
<br>

Merci,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
  Ce mail a été généré automatiquement.
  Si vous souhaitez ne plus en recevoir, vous pouvez éditer vos préférences
  <a href="{{ route('app.user.settings', 'fr') }}" target="_blank" rel="noopener noreferrer">dans vos réglages utilisateur</a>.
@endcomponent
@endcomponent
