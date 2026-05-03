<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title . ' | ' . config('app.name') }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<x-nav.skip-link></x-nav.skip-link>

<h1 class="sr-only">{{ $title }}</h1>

<main id="main-content">

    {{ $slot }}

</main>

<x-partials.footer></x-partials.footer>

</body>
</html>
