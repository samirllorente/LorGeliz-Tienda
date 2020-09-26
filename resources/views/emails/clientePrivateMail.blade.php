@component('mail::message')
# {{ ("Nuevo mensaje") }}

{{ $message }}

@component('mail::button', ['url' => url('/')])
Ir a mi cuenta
@endcomponent

Atentamente,<br>
{{ config('app.name') }}
@endcomponent