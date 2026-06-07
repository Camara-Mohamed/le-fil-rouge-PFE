<x-public.app title="{{ __('public/contact.title') }}">

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/contact.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-16 md:py-20 grid grid-cols-1 md:grid-cols-3 gap-12">

        {{-- Coordonnées --}}
        <div class="col-span-1">
            <x-public.contact.coordonnees />
        </div>


        {{-- Formualire --}}
        <div class="col-span-1 md:col-span-2 md:max-w-lg">
            <x-public.contact.form />
        </div>

    </div>

</x-public.app>
