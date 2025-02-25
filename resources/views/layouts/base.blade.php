<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "I'm lucky!")</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
@yield('content')
@vite('resources/js/app.js')
</body>
</html>
