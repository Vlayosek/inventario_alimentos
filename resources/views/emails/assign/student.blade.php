@component('mail::message')
Hola, {{$user->name}} 

# Ha sido assignado un {{$tipo}}:

@component('mail::panel')
## Adjunto Planilla de Asignación
por favor imprima planilla adjunta a este correo
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent