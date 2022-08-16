@component('mail::message')

هناك عميل في الطاووس vip

@component('mail::button', ['url' => \Illuminate\Support\Facades\URL::to('/')])
    الموقع
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
