<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title . ' | ' . config('app.name') }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans max-w-480 m-auto">

<noscript>
    <div class="w-full px-4 py-3 bg-warning-bg border-b-2 border-warning flex items-center justify-center gap-3">
        <p class="font-serif text-sm text-warning">
            JavaScript est désactivé sur votre navigateur. Certaines fonctionnalités (galerie, notifications) peuvent ne pas fonctionner correctement.
        </p>
    </div>
</noscript>

<x-nav.skip-link></x-nav.skip-link>

<h1 class="sr-only">{{ $title }}</h1>

<x-partials.header></x-partials.header>

<main id="main-content">

    {{ $slot }}

</main>

<x-partials.footer></x-partials.footer>

<livewire:widgets::modal/>
<livewire:widgets::toast/>

</body>
</html>
