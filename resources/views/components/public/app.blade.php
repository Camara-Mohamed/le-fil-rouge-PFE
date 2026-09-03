@props(['title', 'description' => null, 'image' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="author" content="Mohamed Camara - Le Fil Rouge">
    <meta name="description" content="{{ $description ?? __('partials.meta.public.description') }}">
    <meta name="keywords" content="{{ __('partials.meta.public.keywords') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description ?? __('partials.meta.public.description') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    @if($image)
        <meta property="og:image" content="{{ $image }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $image }}">
    @else
        <meta name="twitter:card" content="summary">
    @endif
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description ?? __('partials.meta.public.description') }}">

    @stack('schema')

    <title>{{ $title . ' | ' . config('app.name') }}</title>

    <!-- Logo -->
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans max-w-480 m-auto">

<x-public.no-script/>

<x-nav.skip-link></x-nav.skip-link>

<h1 class="sr-only">{{ $title }}</h1>

<x-partials.header></x-partials.header>

<main id="main-content">

    {{ $slot }}

</main>

<x-partials.footer></x-partials.footer>

<x-public.cookie-banner />

<livewire:widgets::modal/>
<livewire:widgets::toast/>

</body>
</html>
