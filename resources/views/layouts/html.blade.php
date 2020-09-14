<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('headContent', '')
</head>
<body>
    @yield ('bodyContent')
</body>
</html>
