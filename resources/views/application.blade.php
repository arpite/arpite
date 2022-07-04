<!DOCTYPE html>
<html
        lang="{{ str_replace('_', '-', app()->getLocale()) }}"
        class="overflow-y-scroll"
>
    <head>
        <meta charset="utf-8" />
        <meta
                name="viewport"
                content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
