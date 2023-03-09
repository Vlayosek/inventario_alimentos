@component('mail::message')
Hola, {{$postulant->nombres}} {{$postulant->apellidos}} 

# Su solicitud ha sido negada:

@component('mail::panel')
## Motivo
{{$motivo}}
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent