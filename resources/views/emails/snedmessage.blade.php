@component('mail::message')

    سعداء بوجودك في موقع الطاووس نبلغك ان هناك دردشة جماعية في هذا الرابط تخص المنتج عليك الإهتمام بالرد عليها

@component('mail::button', ['url' => route('frontend.group-chat', ['id' => $group_id])])
    دردشة جماعية
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
