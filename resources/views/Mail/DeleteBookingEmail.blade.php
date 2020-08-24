@component('mail::message')
# Bonjour {{ $user->fname }}!

Votre réservation a été supprimée.

<b>Position:</b> {{ $data['position'] }}<br>
<b>Date:</b> {{ $data['date'] }}<br>
<b>Heure:</b> {{ $data['time'] }}<br>
<br>
Vous pouvez consulter vos réservation ici <a href="{{ route('app.atc.mybookings', 'fr') }}" target="_blank" rel="noopener noreferrer"></a>.
<br>

Merci,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  This email was generated automatically.
  If you wish to unsubscribe from emails, you may edit your preferences in
  <a href="{{ route('app.user.settings', 'gb') }}" target="_blank" rel="noopener noreferrer">your user settings panel</a>.
  Ce mail a été généré automatiquement.
  Si vous souhaitez ne plus en recevoir, vous pouvez éditer vos préférences ici : 
  <a href="{{ route('app.user.settings', 'fr') }}" target="_blank" rel="noopener noreferrer">dans vos réglages utilisateur</a>.
@endcomponent
@endcomponent
