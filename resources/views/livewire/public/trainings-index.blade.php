@php
    use App\Enums\TrainingStatus;
    use App\Enums\TrainingTypes;
    use App\Enums\Provinces;
    use App\Models\Training;
@endphp

<div>
    <form method="GET"
          action="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}"
          wire:submit.prevent="filter"
          class="flex flex-wrap items-end gap-4">

        <div class="flex-1 min-w-[200px]">
            <x-public.form.input
                wire:model.live.debounce.300ms="search"
                type="search"
                name="q"
                value="{{ $search }}"
                label="{{ __('public/trainings.search_label') }}"
                placeholder="{{ __('public/trainings.search_placeholder') }}"
            />
        </div>

        <div class="flex w-36">
            <x-public.form.select
                wire:model.live="type"
                name="type"
                label="{{ __('public/trainings.filter_type') }}"
                :options="TrainingTypes::cases()"
                placeholder="{{ __('public/trainings.filter_all') }}"
            />
        </div>

        <div class="flex w-44">
            <x-public.form.select
                wire:model.live="province"
                name="province"
                label="{{ __('public/trainings.filter_province') }}"
                :options="Provinces::cases()"
                placeholder="{{ __('public/trainings.filter_all') }}"
            />
        </div>

        @auth
            <div class="flex w-40">
                <x-public.form.select
                    wire:model.live="status"
                    name="status"
                    label="{{ __('public/trainings.filter_status') }}"
                    :options="TrainingStatus::cases()"
                    placeholder="{{ __('public/trainings.filter_all') }}"
                />
            </div>
        @endauth

        <div class="flex w-48">
            <x-public.form.select
                wire:model.live="sort"
                name="sort"
                label="{{ __('public/trainings.sort_label') }}"
                :options="[
                    ['value' => 'desc', 'label' => __('public/trainings.sort_recent')],
                    ['value' => 'asc',  'label' => __('public/trainings.sort_oldest')],
                ]"
            />
        </div>

        <noscript>
            <button type="submit"
                    class="shrink-0 h-11 px-5 inline-flex items-center gap-2 bg-dark text-white font-sans font-bold text-sm rounded-lg hover:bg-dark-mid transition duration-200">
                {{ __('public/trainings.search_submit') }}
            </button>
        </noscript>

        @can('create', Training::class)
            <a href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}"
               wire:navigate
               class="flex-1 min-w-max h-11 inline-flex items-center justify-center gap-2 px-5 bg-red text-white font-sans font-bold text-sm rounded-lg hover:bg-red-mid transition duration-200">
                <x-icons.plus class="size-4" />
                {{ __('public/trainings.create_link') }}
            </a>
        @endcan

    </form>

    @if($search || $type || $province || $status)
        <div class="mt-3 flex justify-end">
            <button type="button" wire:click="resetFilters"
                    class="font-sans text-sm text-dark-mid hover:text-dark underline transition duration-200">
                {{ __('public/trainings.reset_filters') }}
            </button>
        </div>
    @endif

    <div wire:loading.class="opacity-50 transition-opacity duration-200"
         class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($trainings as $training)
            <x-public.trainings.card :training="$training" />
        @empty
            <p class="col-span-3 font-serif text-dark-mid text-center py-16">
                {{ __('public/trainings.empty') }}
            </p>
        @endforelse
    </div>

    @if($trainings->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $trainings->links('pagination::tailwind') }}
        </div>
    @endif
</div>
