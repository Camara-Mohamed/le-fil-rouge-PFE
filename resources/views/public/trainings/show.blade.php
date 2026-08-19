@php
    use App\Enums\UserRoles;
    $isFull = $training->participants && $training->acceptedRegisters->count() >= $training->participants;
    $days   = max(1, (int) ceil($training->start_date->floatDiffInDays($training->end_date)));
@endphp

@php
    $trainingSchema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'EducationEvent',
        'name'        => $training->title,
        'description' => $training->description,
        'startDate'   => $training->start_date->toIso8601String(),
        'endDate'     => $training->end_date->toIso8601String(),
        'url'         => route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training]),
        'organizer'   => [
            '@type' => 'Organization',
            'name'  => config('app.name'),
            'url'   => config('app.url'),
        ],
    ];
    if ($training->banner) {
        $trainingSchema['image'] = Storage::url($training->banner);
    }
    if ($training->city) {
        $addr = ['@type' => 'PostalAddress', 'addressLocality' => $training->city, 'addressCountry' => 'BE'];
        if ($training->address) $addr['streetAddress'] = trim($training->address . ' ' . ($training->number ?? ''));
        if ($training->postal_code) $addr['postalCode'] = $training->postal_code;
        $trainingSchema['location'] = ['@type' => 'Place', 'address' => $addr];
    }
    if ($training->participants) {
        $trainingSchema['maximumAttendeeCapacity']   = $training->participants;
        $trainingSchema['remainingAttendeeCapacity'] = max(0, $training->participants - $training->acceptedRegisters->count());
    }
    if ($training->price !== null) {
        $trainingSchema['offers'] = [
            '@type'         => 'Offer',
            'price'         => $training->price,
            'priceCurrency' => 'EUR',
            'availability'  => $isFull ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock',
        ];
    }
@endphp
@push('schema')
<script type="application/ld+json">{!! json_encode($trainingSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app title="{{ $training->title }}">

    @php
        $srcset = null;
        if ($training->banner) {
            $variantName  = pathinfo(basename($training->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
            $variantsBase = config('banners.paths.trainings.variants');
            $srcset       = collect(config('banners.sizes.banner'))
                ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                ->implode(', ');
        }
    @endphp

    {{-- Hero --}}
    <x-public.hero
        title="{{ $training->title }}"
        :banner="$training->banner ? Storage::url($training->banner) : null"
        :srcset="$srcset"
    />

    <div class="px-4 md:px-6 lg:px-8 pt-8 pb-4 flex items-center justify-between gap-6 flex-wrap">
        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
            ['label' => __('breadcrumbs.trainings'), 'url' => route('public.trainings.index', ['locale' => app()->getLocale()])],
            ['label' => $training->title],
        ]" />

        @can('update', $training)
            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ route('admin.trainings.edit', ['locale' => app()->getLocale(), 'training' => $training]) }}"
                   wire:navigate
                   class="font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                    {{ __('general.edit') }}
                </a>
                <button type="button"
                    x-data
                    @click="Livewire.dispatch('open_modal', { payload: { form: 'modals::trainings.confirm-delete', model_id: '{{ $training->id }}', model_type: 'training' } })"
                    class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                    {{ __('general.delete') }}
                </button>
            </div>
        @endcan
    </div>

    {{-- Content --}}
    <section aria-label="{{ $training->title }}" class="px-4 md:px-6 lg:px-8 pb-16">

        @can('update', $training)
            @php
                $statusVariant = match($training->status->value) {
                    'published' => 'success',
                    'confirmed' => 'info',
                    'refused'   => 'danger',
                    default     => 'warning',
                };
            @endphp
            <div class="mb-12">
                <x-public.badge :variant="$statusVariant">{{ $training->status->label() }}</x-public.badge>
            </div>
        @endcan

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Les Informations --}}
            <div class="flex flex-col gap-12">
                <h3 class="font-sans font-black text-3xl text-dark">{{ __('public/trainings.show_info_title') }}</h3>
                <div class="flex flex-col gap-6">

                    <x-public.accordion :summary="__('public/trainings.show_description_accordion')" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                        <x-public.content class="text-sm leading-5 whitespace-pre-line">{!! $training->description !!}</x-public.content>
                    </x-public.accordion>

                    @if($training->details)
                        <x-public.accordion :summary="__('public/trainings.show_objectives_accordion')" :open="true" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark whitespace-pre-line">{!! $training->details !!}</div>
                        </x-public.accordion>
                    @endif

                    @if($training->constraints)
                        <x-public.accordion :summary="__('public/trainings.show_constraints_accordion')" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark whitespace-pre-line">{!! $training->constraints !!}</div>
                        </x-public.accordion>
                    @endif

                </div>
            </div>

            {{-- Détails --}}
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-6">

                    <h3 class="font-sans font-black text-3xl text-dark">{{ __('public/trainings.show_details_title') }}</h3>

                    <div class="flex flex-wrap gap-4">
                        @if($training->price !== null)
                            <x-public.badge variant="danger">{{ $training->getFormattedPrice() }}</x-public.badge>
                        @endif
                        <x-public.badge variant="info">
                            {{ trans_choice('general.day', $days, ['count' => $days]) }}
                        </x-public.badge>
                        @if($training->participants)
                            <x-public.badge variant="{{ $isFull ? 'danger' : 'success' }}">
                                {{ $training->acceptedRegisters->count() }} / {{ $training->participants }}
                            </x-public.badge>
                        @endif
                        @if($training->province)
                            <x-public.badge variant="warning">{{ $training->province->label() }}</x-public.badge>
                        @endif
                    </div>

                    <x-public.content class="text-base leading-6 whitespace-pre-line">{!! $training->description !!}</x-public.content>

                    <div class="flex flex-col gap-2">
                        <p class="font-sans text-base">
                            <span class="font-bold underline uppercase">{{ __('general.date_label') }} :</span>
                            <span class="uppercase">
                                {{ $training->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                                – {{ $training->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                            </span>
                        </p>
                        @if($training->city)
                            <p class="font-sans text-base">
                                <span class="font-bold underline uppercase">{{ __('general.address_label') }} :</span>
                                <span class="uppercase">
                                    @if($training->address) {{ $training->address }} {{ $training->number }}, @endif
                                    @if($training->postal_code) {{ $training->postal_code }} @endif
                                    {{ $training->city }}
                                </span>
                            </p>
                        @endif
                    </div>

                    @if($training->roles)
                        <div class="flex flex-wrap gap-3">
                            @foreach($training->roles as $role)
                                @php $role = UserRoles::tryFrom($role); @endphp
                                @if($role)
                                    <span class="px-6 py-0.5 bg-warning-bg border border-warning rounded-2xl font-sans text-sm font-medium leading-6 text-red">
                                        {{ $role->label() }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>

                @auth
                    <livewire:enrollment :model="$training" />

                    @if($training->isConfirmed())
                        @can('update', $training)
                            <a href="{{ route('admin.trainings.pdf', ['locale' => app()->getLocale(), 'training' => $training]) }}"
                               target="_blank"
                               class="self-start font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                                {{ __('public/trainings.show_download_summary') }}
                            </a>
                        @endcan
                    @endif
                @endauth
            </div>

        </div>
    </section>

    {{-- Inscrits --}}
    @auth
        @unless(auth()->user()->isArrivant())
        <section aria-labelledby="inscrits-heading" class="px-4 md:px-6 lg:px-8 pb-16">
            <h2 id="inscrits-heading" class="sr-only">{{ __('livewire/enrollment.inscrits_section') }}</h2>
            <livewire:registers-cta :model="$training" />
        </section>
        @endunless
    @endauth

    {{-- Galerie --}}
    @if($training->galeries->count())
        <section aria-labelledby="galerie-heading" class="px-4 md:px-6 lg:px-8 pb-16">
            <h2 id="galerie-heading" class="font-sans font-black text-3xl text-dark mb-6">{{ __('public/trainings.gallery_title') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($training->galeries as $galerie)
                    <a href="{{ Storage::url($galerie->path) }}" data-fancybox="galerie-training">
                        <img src="{{ Storage::url($galerie->path) }}"
                             alt="Photo {{ $loop->iteration }} — {{ $training->title }}"
                             class="w-full h-48 object-cover rounded-2xl" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Commentaires --}}
    @auth
        <section aria-labelledby="section-commentaires" class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:comments :model="$training" />
        </section>
    @endauth

    <livewire:widgets::modal />

</x-public.app>
