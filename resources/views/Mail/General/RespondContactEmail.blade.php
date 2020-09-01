@component('mail::message')
# Response to a contact request / Réponse à une requête

### Question from / Question de {{$user->fname}} {{$user->lname}} ({{$user->vatsim_id}}):
@component('mail::panel')
{!! nl2br($question) !!}
@endcomponent

### Response from Staff / Réponse du Staff:
@component('mail::panel')
{!! nl2br($response) !!}
@endcomponent

@component('mail::button', ['url' => route('discord.invite')])
Join our Discord / Rejoignez notre Discord !
@endcomponent

Kind regards,<br>
{{ config('app.name') }} Staff
@endcomponent
