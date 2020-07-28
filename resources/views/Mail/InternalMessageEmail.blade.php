@component('mail::message')
# Hello {{ $user->fname }}

You received a new message!

<b>From: </b> {{ $data['sender'] }}<br>
<b>Subject: </b> {{ $data['subject'] }}<br>
<b>Content: </b><br>
@component('mail::panel')
{!! $data['body'] !!}
@endcomponent
<br>

@component('mail::button', ['url' => route('app.inmsg.read', app()->getLocale())."?msgid=".$data['id']])
Read message
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
@endcomponent
@endcomponent
