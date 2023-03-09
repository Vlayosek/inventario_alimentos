@component('mail::message')
Hola, {{$user->name}}

# Su solicitud ha sido negada:

@component('mail::panel')
## Motivo
{{$motivo}}
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent
