@component('mail::message')
# Nouvelle Demande de Mentoring ATC

<b>Demandeur: </b> {{ $data['sender'] }}<br>
<b>Motivation: </b><br>
@component('mail::panel')
{!! $data['body'] !!}
@endcomponent
<br>

@component('mail::button', ['url' => route('app.staff.atc.all', app()->getLocale())])
Voir demande
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
