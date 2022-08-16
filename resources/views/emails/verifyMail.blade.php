<!DOCTYPE html>
<html>
<head>
    <title>Altaawus</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>
        لتفعيل بريدك الالكتروني اضغط <a href="{{URL::to('verify-email/'.$details['body'])}}">هنا</a>
        
    </p>
</body>
</html>