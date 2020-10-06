@component('mail::message')
# Bonjour {{ $user->fname }}

Vous avez reçu un nouveau message !

<b>De : </b> {{ $data['sender'] }}<br>
<b>Objet : </b> {{ $data['subject'] }}<br>
<b>Contenu : </b><br>
@component('mail::panel')
{!! $data['body'] !!}
@endcomponent
<br>

@component('mail::button', ['url' => route('app.inmsg.read', app()->getLocale())."?msgid=".$data['id']])
Lire le message
@endcomponent

Thanks,<br>
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
