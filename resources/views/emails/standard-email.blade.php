@component('mail::message')
    ## {{$emailSubject}}

    {!! $content !!}

@component('mail::button', ['url' => $buttonUrl])
{{$buttonText}}
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
