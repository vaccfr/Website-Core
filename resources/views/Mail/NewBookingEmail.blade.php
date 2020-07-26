@component('mail::message')
# Hello {{ $user->fname }}!

A new ATC booking was registered on your account.

<b>Position:</b> {{ $data['position'] }}<br>
<b>Date:</b> {{ $data['date'] }}<br>
<b>Time:</b> {{ $data['time'] }}<br>

@component('mail::button', ['url' => route('app.atc.mybookings', 'fr')])
View your bookings
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
