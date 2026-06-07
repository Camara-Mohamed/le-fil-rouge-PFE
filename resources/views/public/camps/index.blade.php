<x-public.app title="{{ __('public/camps.title') }}">

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/camps.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-12">
        <livewire:public.camps-index />
    </div>

    <x-public.camps.feature />

    <x-public.gallery
        :images="['holiday', 'holiday_1', 'holiday_2', 'holiday_3', 'holiday_4', 'holiday_5']"
        base="images/camps"
        title="{{ __('public/camps.gallery_title') }}"
        alt="{{ __('public/camps.hero_alt') }}"
        group="gallery-camps"
    />

</x-public.app>
