<x-public.app title="{{ __('public/home.title') }}">

    {{-- Hero --}}
    <x-public.home.hero />

    {{-- Liste des actualités récentes --}}
    <x-public.home.announcements :announcements="$announcements" />

    {{-- À propos --}}
    <x-public.home.about />

    {{-- CTA (Formations et Camps) --}}
    <x-public.home.cta />

    {{-- Statistiques + CTA (Devenir Volontaire) --}}
    <x-public.home.volunteer />

</x-public.app>
