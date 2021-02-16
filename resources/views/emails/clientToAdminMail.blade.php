@component('mail::message')
# {{ $details['title'] }}

{{ $details['cliente'] }} te ha enviado el siguiente mensaje:

{{ $details['mensaje'] }}.

@component('mail::button', ['url' => $details['url']])
Ver cliente
@endcomponent

Gracias por tu atención,<br>
{{ config('app.name') }}
@endcomponent