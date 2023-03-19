<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BLACKLIST</title>
</head>

<style>
    body {
        background:red;
        color:white;
    }
</style>
<body>

    <div style="width: 100%;height:100vh;display:flex;justify-content:center;align-items:center;">
        <div>
            <h3>{{GoogleTranslate::trans("You're Account has been blacklisted", app()->getLocale()) }}</h3>
            <p>{{GoogleTranslate::trans('check your email', app()->getLocale()) }}</p>
        </div>
    </div>


</body>
</html>
