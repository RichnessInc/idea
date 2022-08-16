@component('mail::message')

    اضفط على اعادة كلمة السر خلال 60 دقيقة من تاريخ ارسال البريد الالكتروني

@component('mail::button', ['url' => route('reset_password', $token)])
    إستعادة كلمة السر
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
