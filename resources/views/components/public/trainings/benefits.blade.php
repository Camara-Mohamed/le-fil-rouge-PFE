<section aria-labelledby="section-benefits" class="px-4 md:px-6 lg:px-8 py-16 md:py-20">
    <h2 id="section-benefits" class="sr-only">{{ __('public/trainings.benefits_title') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-public.trainings.benefit-card number="01" title="{{ __('public/trainings.benefit_1_title') }}" description="{{ __('public/trainings.benefit_1_desc') }}" />
        <x-public.trainings.benefit-card number="02" title="{{ __('public/trainings.benefit_2_title') }}" description="{{ __('public/trainings.benefit_2_desc') }}" />
        <x-public.trainings.benefit-card number="03" title="{{ __('public/trainings.benefit_3_title') }}" description="{{ __('public/trainings.benefit_3_desc') }}" />
        <x-public.trainings.benefit-card number="04" title="{{ __('public/trainings.benefit_4_title') }}" description="{{ __('public/trainings.benefit_4_desc') }}" />
    </div>
</section>
