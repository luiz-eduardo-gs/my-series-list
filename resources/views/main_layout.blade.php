<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('css')
    <link rel="stylesheet" href="{{ URL::asset('static/css/main.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('static/css/alerts.css') }}" />
</head>
<body>
    @yield('body')
</body>
</html>