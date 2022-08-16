@component('mail::message')
# مرحبا {{$name}}

سعداء بوجودك في موقع الطاووس وهذا رابط الدردشة الجماعية الخاص بالمنتج الذي تم شراءه الأن

@component('mail::button', ['url' => route('frontend.group-chat', ['id' => $group_id])])
    رابط الدردشة
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
