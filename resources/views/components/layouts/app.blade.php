<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Todo List' }}</title>
</head>
<body class="bg-gray-200">
<div>
{{ $slot }}
</body>
</html>
