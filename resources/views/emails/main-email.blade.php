@component('mail::message')

    {{$content}}
@component('mail::button', ['url' => route('frontend.home')])
الموقع
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
