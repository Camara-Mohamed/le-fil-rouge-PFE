@php
    use App\Enums\UserRoles;
    $isFull = $camp->participants && $camp->acceptedRegisters->count() >= $camp->participants;
    $days   = max(1, (int) ceil($camp->start_date->floatDiffInDays($camp->end_date)));
@endphp

@php
    $campSchema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Event',
        'name'        => $camp->title,
        'description' => $camp->description,
        'startDate'   => $camp->start_date->toIso8601String(),
        'endDate'     => $camp->end_date->toIso8601String(),
        'url'         => route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp]),
        'organizer'   => [
            '@type' => 'Organization',
            'name'  => config('app.name'),
            'url'   => config('app.url'),
        ],
    ];
    if ($camp->banner) {
        $campSchema['image'] = Storage::url($camp->banner);
    }
    if ($camp->city) {
        $addr = ['@type' => 'PostalAddress', 'addressLocality' => $camp->city, 'addressCountry' => 'BE'];
        if ($camp->address) $addr['streetAddress'] = trim($camp->address . ' ' . ($camp->number ?? ''));
        if ($camp->postal_code) $addr['postalCode'] = $camp->postal_code;
        $campSchema['location'] = ['@type' => 'Place', 'address' => $addr];
    }
    if ($camp->participants) {
        $campSchema['maximumAttendeeCapacity']   = $camp->participants;
        $campSchema['remainingAttendeeCapacity'] = max(0, $camp->participants - $camp->acceptedRegisters->count());
    }
@endphp
@push('schema')
<script type="application/ld+json">{!! json_encode($campSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app :title="$camp->title">

    @php
        $srcset = null;
        if ($camp->banner) {
            $variantName  = pathinfo(basename($camp->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
            $variantsBase = config('banners.paths.camps.variants');
            $srcset       = collect(config('banners.sizes.banner'))
                ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                ->implode(', ');
        }
    @endphp

    {{-- Hero --}}
    <x-public.hero
        :title="$camp->title"
        :banner="$camp->banner ? Storage::url($camp->banner) : null"
        :srcset="$srcset"
    />

    <div class="px-4 md:px-6 lg:px-8 pt-8 pb-4 flex items-center justify-between gap-6 flex-wrap">
        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
            ['label' => __('breadcrumbs.camps'), 'url' => route('public.camps.index', ['locale' => app()->getLocale()])],
            ['label' => $camp->title],
        ]" />

        @can('update', $camp)
            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ route('admin.camps.edit', ['locale' => app()->getLocale(), 'camp' => $camp]) }}"
                   wire:navigate
                   class="font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                    {{ __('general.edit') }}
                </a>
                <button type="button"
                    x-data
                    @click="Livewire.dispatch('open_modal', { payload: { form: 'modals::camps.confirm-delete', model_id: '{{ $camp->id }}', model_type: 'camp' } })"
                    class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                    {{ __('general.delete') }}
                </button>
            </div>
        @endcan
    </div>

    {{-- Content --}}
    <section aria-label="{{ $camp->title }}" class="px-4 md:px-6 lg:px-8 pb-16">

        @can('update', $camp)
            @php
                $statusVariant = match($camp->status->value) {
                    'published' => 'success',
                    'confirmed' => 'info',
                    'refused'   => 'danger',
                    default     => 'warning',
                };
            @endphp
            <div class="mb-12">
                <x-public.badge :variant="$statusVariant">{{ $camp->status->label() }}</x-public.badge>
            </div>
        @endcan

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Les Informations --}}
            <div class="flex flex-col gap-12">
                <h3 class="font-sans font-black text-3xl text-dark">{{ __('public/camps.show_info_title') }}</h3>
                <div class="flex flex-col gap-6">

                    <x-public.accordion :summary="__('public/camps.show_description_accordion')" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                        <x-public.content class="text-sm leading-5 whitespace-pre-line">{{ $camp->description }}</x-public.content>
                    </x-public.accordion>

                    @if($camp->details)
                        <x-public.accordion :summary="__('public/camps.show_objectives_accordion')" :open="true" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark whitespace-pre-line">{{ $camp->details }}</div>
                        </x-public.accordion>
                    @endif

                    @if($camp->constraints)
                        <x-public.accordion :summary="__('public/camps.show_constraints_accordion')" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark whitespace-pre-line">{{ $camp->constraints }}</div>
                        </x-public.accordion>
                    @endif

                </div>
            </div>

            {{-- Détails --}}
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-6">

                    <h3 class="font-sans font-black text-3xl text-dark">{{ __('public/camps.show_details_title') }}</h3>

                    <div class="flex flex-wrap gap-4">
                        @if($camp->participants)
                            <x-public.badge variant="{{ $isFull ? 'danger' : 'success' }}">
                                {{ $camp->acceptedRegisters->count() }} / {{ $camp->participants }}
                            </x-public.badge>
                        @endif
                        <x-public.badge variant="info">
                            {{ trans_choice('general.day', $days, ['count' => $days]) }}
                        </x-public.badge>
                        @if($camp->province)
                            <x-public.badge variant="warning">{{ $camp->province->label() }}</x-public.badge>
                        @endif
                        <x-public.badge variant="danger">{{ $camp->type->label() }}</x-public.badge>
                    </div>

                    <x-public.content class="text-base leading-6 whitespace-pre-line">{{ $camp->description }}</x-public.content>

                    <div class="flex flex-col gap-2">
                        <p class="font-sans text-base">
                            <span class="font-bold underline uppercase">{{ __('general.date_label') }} :</span>
                            <span class="uppercase">
                                {{ $camp->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                                – {{ $camp->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                            </span>
                        </p>
                        @if($camp->city)
                            <p class="font-sans text-base">
                                <span class="font-bold underline uppercase">{{ __('general.address_label') }} :</span>
                                <span class="uppercase">
                                    @if($camp->address) {{ $camp->address }} {{ $camp->number }}, @endif
                                    @if($camp->postal_code) {{ $camp->postal_code }} @endif
                                    {{ $camp->city }}
                                </span>
                            </p>
                        @endif
                    </div>

                    @if($camp->roles)
                        <div class="flex flex-wrap gap-3">
                            @foreach($camp->roles as $role)
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

                {{-- Inscription --}}
                @auth
                    <livewire:enrollment :model="$camp" />

                    @if($camp->isConfirmed())
                        @can('update', $camp)
                            <a href="{{ route('admin.camps.pdf', ['locale' => app()->getLocale(), 'camp' => $camp]) }}"
                               target="_blank"
                               class="self-start font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                                {{ __('public/camps.show_download_summary') }}
                            </a>
                        @endcan

                        @if($myRegister)
                            <a href="{{ route('admin.camps.register.pdf', ['locale' => app()->getLocale(), 'camp' => $camp, 'register' => $myRegister]) }}"
                               target="_blank"
                               class="self-start font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                                {{ __('public/camps.show_download_contract') }}
                            </a>
                        @endif
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
            <livewire:registers-cta :model="$camp" />
        </section>
        @endunless
    @endauth

    {{-- Galerie --}}
    @if($camp->galeries->count())
        <section aria-labelledby="galerie-heading" class="px-4 md:px-6 lg:px-8 pb-16">
            <h2 id="galerie-heading" class="font-sans font-black text-3xl text-dark mb-6">{{ __('public/camps.gallery_title') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($camp->galeries as $galerie)
                    <a href="{{ Storage::url($galerie->path) }}" data-fancybox="galerie-camp">
                        <img src="{{ Storage::url($galerie->path) }}"
                             alt="Photo {{ $loop->iteration }} — {{ $camp->title }}"
                             class="w-full h-48 object-cover rounded-2xl" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Commentaires --}}
    @auth
        <section aria-labelledby="section-commentaires" class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:comments :model="$camp" />
        </section>
    @endauth

    <livewire:widgets::modal />

</x-public.app>
