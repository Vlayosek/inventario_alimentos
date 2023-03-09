@component('mail::message')
# Te damos la Bienvenida a nuestro sistema JuridiCore

Hola, {{$user->name}}

@component('mail::panel')
## Datos de Acceso
Usuario: {{$user->empleado_id}}
<br>
Contraseña: {{$password}}
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent
