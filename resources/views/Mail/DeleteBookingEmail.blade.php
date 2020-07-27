@component('mail::message')
# Hello {{ $user->fname }}!

Your ATC Booking was deleted.

<b>Position:</b> {{ $data['position'] }}<br>
<b>Date:</b> {{ $data['date'] }}<br>
<b>Time:</b> {{ $data['time'] }}<br>
<br>
You can view and edit your bookings on <a href="{{ route('app.atc.mybookings', 'gb') }}" target="_blank" rel="noopener noreferrer">your ATC bookings page</a>.
<br>

Thanks,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
