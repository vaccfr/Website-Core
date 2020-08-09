@component('mail::message')
# ATC Training Center

New Training Session request from {{ $data['mentor_fname'] }} <br>

<b>Position:</b> {{ $data['position'] }} <br>
<b>Date:</b> {{ $data['date'] }} <br>
<b>Time (UTC):</b> {{ $data['time'] }} <br>

@component('mail::button', ['url' => route('app.atc.training', app()->getLocale())])
Accept / Refuse session
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
