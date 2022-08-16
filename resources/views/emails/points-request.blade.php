@component('mail::message')

تم ترقيه الحساب

@component('mail::button', ['url' => route('frontend.home')])
الموقع
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
