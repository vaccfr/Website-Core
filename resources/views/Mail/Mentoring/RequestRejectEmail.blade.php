@component('mail::message')
# Demande de Mentoring ATC rejetée

<b>Demandeur: </b> {{ $data['student'] }}<br>
<b>Rejeté par: </b> {{ $data['rejector'] }}<br>
<b>Justification: </b><br>
@component('mail::panel')
{!! $data['body'] !!}
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
