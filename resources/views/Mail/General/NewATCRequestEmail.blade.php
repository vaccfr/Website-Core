@component('mail::message')
# Nouvelle requête ATC

<b>Envoyé par:</b> {{$eventData->name}} ({{$eventData->vatsim_id}}) <br>
<b>Nom de l'event:</b> {{$eventData->event_name}} <br>
<b>Date de l'event:</b> {{$eventData->event_date}} <br>
<b>Site web:</b> {{ $eventData->event_website }} <br>
<b>Pilotes attendus:</b> {{ $eventData->expected_pilots }} <br>

# Informations Générales
<b>Départ et destination</b>
@component('mail::panel')
{{$eventData->dep_airport_and_time}} -> {{$eventData->arr_airport_and_time}}
@endcomponent

<b>Route</b>
@component('mail::panel')
{{$eventData->route}}
@endcomponent

<b>Positions requises</b>
@component('mail::panel')
{{$eventData->requested_positions}}
@endcomponent

<b>Informations complémentaires</b>
@component('mail::panel')
{{$eventData->message}}
@endcomponent

@component('mail::button', ['url' => route('app.staff.atcadmin', 'fr')])
Voir toutes les informations
@endcomponent

Merci,<br>
{{ config('app.name') }} Staff team

@component('mail::subcopy')
  Cet email vous a été envoyé automatiquement car vous faites partie du Staff.
@endcomponent
@endcomponent
