@component('mail::message')
    # مرحبا

    سعداء بوجودك في موقع الطاووس وهذا رابط الدردشة الجماعية الخاص بالمنتج الذي تم شراءه الأن

    @component('mail::button', ['url' => route('dashboard.admin.group.single', ['id' => $group_id])])
        رابط الدردشة
    @endcomponent

    شكرا,<br>
    {{ config('app.name') }}
@endcomponent
