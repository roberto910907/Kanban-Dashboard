<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">

    <title>Kanban Dashboard</title>

    @vite(['resources/js/app.js', 'resources/css/app.scss'])
</head>
<body>
<div id="app">
    <App class="text-base"></App>
</div>
</body>
</html>
