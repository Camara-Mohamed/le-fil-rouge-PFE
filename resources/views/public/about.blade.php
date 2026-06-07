<x-public.app title="{{ __('public/about.title') }}">

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/about.title') }}" />

    {{-- Histoire + CTA(Volontaire) --}}
    <x-public.about.histoire />

    {{-- Valeurs --}}
    <x-public.about.valeurs />

    {{-- Statistiques --}}
    <x-public.about.stats :stats="$stats" />

    {{-- FAQ --}}
    <x-public.about.faq />

</x-public.app>
