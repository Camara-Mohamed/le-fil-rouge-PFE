<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title . ' | ' . config('app.name') }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans bg-bg flex items-center justify-center px-4 py-12">

<x-public.no-script/>

<h1 class="sr-only">{{ $title }}</h1>

<div class="w-full max-w-md flex flex-col gap-6">

    <div class="bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] p-8 flex flex-col items-center gap-8">

        <x-nav.logo />

        {{ $slot }}

    </div>

    @isset($more_cta)
        <div class="flex flex-col gap-4">
            <hr class="border-bg-dark" />
            {{ $more_cta }}
        </div>
    @endisset

</div>

</body>
</html>
