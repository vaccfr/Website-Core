@component('mail::message')
# Hello {{ $user->fname }}!

A new ATC booking was registered on your account.

<b>Position:</b> {{ $data['position'] }}<br>
<b>Date:</b> {{ $data['date'] }}<br>
<b>Time:</b> {{ $data['time'] }}<br>
<br>
You can view and edit your bookings on <a href="{{ route('app.atc.mybookings', 'gb') }}" target="_blank" rel="noopener noreferrer">your ATC bookings page</a>.
<br>

Thanks,<br>
{{ config('app.name') }} Staff team
<br>
<br>
@if (!is_null($calendarLinks['ics']))
<div align="center">
  <a href="{{ $calendarLinks['ics'] }}" class="button button-primary" target="_blank" rel="noopener">Add to calendar</a>
  <a href="{{ $calendarLinks['google'] }}" class="button button-primary" target="_blank" rel="noopener">Add to Google calendar</a>
</div>
@endif

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
