<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }
        img {
            width: 100%;
            height: 100vh;
        }
        button {
            width: 100px;
            position: absolute;
            bottom: 75px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4080fe;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            direction: rtl;
            text-decoration: none;
            color: #fefdf4;
            border-radius: 25px;
        }
    </style>
</head>
<body>
<img src="{{asset('errors/419.jpg')}}">
<a href="{{URL::to('/')}}">رجوع للرئيسية</a>
</body>
</html>
