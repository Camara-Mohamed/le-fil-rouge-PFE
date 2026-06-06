@php
    use App\Enums\UserRoles;
    $isFull = $training->participants && $training->acceptedRegisters->count() >= $training->participants;
    $days   = max(1, (int) ceil($training->start_date->floatDiffInDays($training->end_date)));
@endphp

<x-public.app title="{{ $training->title }}">

    {{-- Bannière --}}
    @if($training->banner)
        @php
            $variantName  = pathinfo(basename($training->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
            $variantsBase = config('banners.paths.trainings.variants');
            $srcset       = collect(config('banners.sizes.banner'))
                ->map(fn($w) => asset("storage/{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                ->implode(', ');
        @endphp
        <div class="px-4 md:px-6 lg:px-8 pb-10">
            <img src="{{ asset('storage/' . $training->banner) }}"
                 srcset="{{ $srcset }}"
                 sizes="100vw"
                 alt="{{ $training->title }}"
                 class="w-full h-64 md:h-96 object-cover rounded-2xl"
                 loading="eager" />
        </div>
    @endif

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
                    Modifier
                </a>
                <button
                    x-data
                    @click="Livewire.dispatch('open_modal', { payload: { form: 'modals::trainings.confirm-delete', model_id: '{{ $training->id }}', model_type: 'training' } })"
                    class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                    Supprimer
                </button>
            </div>
        @endcan
    </div>

    {{-- Content --}}
    <section aria-labelledby="training-heading" class="px-4 md:px-6 lg:px-8 pb-16">

        <div class="flex items-center gap-4 mb-12">
            <h2 id="training-heading" class="font-sans font-black text-3xl text-dark">{{ $training->title }}</h2>
            @can('update', $training)
                @php
                    $statusVariant = match($training->status->value) {
                        'published' => 'success',
                        'confirmed' => 'info',
                        'refused'   => 'danger',
                        default     => 'warning',
                    };
                @endphp
                <x-public.badge :variant="$statusVariant" class="shrink-0">
                    {{ $training->status->label() }}
                </x-public.badge>
            @endcan
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Les Informations --}}
            <div class="flex flex-col gap-12">
                <h3 class="font-sans font-black text-3xl text-dark">Les Informations</h3>
                <div class="flex flex-col gap-6">

                    <x-public.accordion summary="Description" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                        <x-public.content class="text-sm leading-5">{{ $training->description }}</x-public.content>
                    </x-public.accordion>

                    @if($training->details)
                        <x-public.accordion summary="Objectifs" :open="true" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark">{!! $training->details !!}</div>
                        </x-public.accordion>
                    @endif

                    @if($training->constraints)
                        <x-public.accordion summary="Contraintes" class="bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red px-6 pt-4 pb-3">
                            <div class="font-serif text-sm leading-5 text-dark">{!! $training->constraints !!}</div>
                        </x-public.accordion>
                    @endif

                </div>
            </div>

            {{-- Description --}}
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-6">

                    <h3 class="font-sans font-black text-3xl text-dark">Description</h3>

                    <div class="flex flex-wrap gap-4">
                        @if($training->price !== null)
                            <x-public.badge variant="danger">{{ $training->getFormattedPrice() }}</x-public.badge>
                        @endif
                        <x-public.badge variant="info">
                            {{ $days }} {{ $days > 1 ? 'jours' : 'jour' }}
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

                    <x-public.content class="text-base leading-6">{{ $training->description }}</x-public.content>

                    <div class="flex flex-col gap-2">
                        <p class="font-sans text-base">
                            <span class="font-bold underline uppercase">Date :</span>
                            <span class="uppercase">
                                Du {{ $training->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                                au {{ $training->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                            </span>
                        </p>
                        @if($training->city)
                            <p class="font-sans text-base">
                                <span class="font-bold underline uppercase">Adresse :</span>
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
                                Télécharger le récapitulatif (PDF)
                            </a>
                        @endcan
                    @endif
                @endauth
            </div>

        </div>
    </section>

    {{-- Inscrits --}}
    @auth
        <section class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:registers-cta :model="$training" />
        </section>
    @endauth

    {{-- Galerie --}}
    @if($training->galeries->count())
        <section aria-labelledby="galerie-heading" class="px-4 md:px-6 lg:px-8 pb-16">
            <h2 id="galerie-heading" class="font-sans font-black text-3xl text-dark mb-6">Galerie</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($training->galeries as $galerie)
                    <a href="{{ asset('storage/' . $galerie->path) }}" data-fancybox="galerie-training">
                        <img src="{{ asset('storage/' . $galerie->path) }}"
                             alt="{{ $training->title }}"
                             class="w-full h-48 object-cover rounded-2xl" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Commentaires --}}
    @auth
        <section class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:comments :model="$training" />
        </section>
    @endauth

    <livewire:widgets::modal />

</x-public.app>
