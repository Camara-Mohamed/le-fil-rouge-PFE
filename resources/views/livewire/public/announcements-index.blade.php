@php
    use App\Models\Announcement;
@endphp

<div>
    <form method="GET"
          action="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"
          wire:submit.prevent="filter"
          class="flex flex-wrap items-end gap-4">

        <div class="flex-1 min-w-[200px]">
            <x-public.form.input
                wire:model.live.debounce.300ms="search"
                type="search"
                name="q"
                value="{{ $search }}"
                label="{{ __('public/announcements.search_label') }}"
                placeholder="{{ __('public/announcements.search_placeholder') }}"
            />
        </div>

        <div class="flex w-48">
            <x-public.form.select
                wire:model.live="sort"
                name="sort"
                label="{{ __('public/announcements.sort_label') }}"
                :options="[
                    ['value' => 'desc', 'label' => __('public/announcements.sort_recent')],
                    ['value' => 'asc',  'label' => __('public/announcements.sort_oldest')],
                ]"
            />
        </div>

        <noscript>
            <button type="submit"
                    class="shrink-0 h-11 px-5 inline-flex items-center gap-2 bg-dark text-white font-sans font-bold text-sm rounded-lg hover:bg-dark-mid transition duration-200">
                {{ __('public/announcements.search_submit') }}
            </button>
        </noscript>

        @can('create', Announcement::class)
            <a href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}"
               wire:navigate
               class="flex-1 min-w-max h-11 inline-flex items-center justify-center gap-2 px-5 bg-red text-white font-sans font-bold text-sm rounded-lg hover:bg-red-mid transition duration-200">
                <x-icons.plus class="size-4" />
                {{ __('public/announcements.create_link') }}
            </a>
        @endcan

    </form>

    @if($search)
        <div class="mt-3 flex justify-end">
            <noscript>
                <a href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"
                   class="font-sans text-sm text-dark-mid hover:text-dark underline transition duration-200">
                    {{ __('public/announcements.reset_filters') }}
                </a>
            </noscript>
        </div>
    @endif

    <div class="mt-8 grid grid-cols-3 gap-6">
        @forelse($announcements as $announcement)
            @if($loop->first)
                <div class="col-span-2 row-span-2">
                    <x-public.announcements.card :announcement="$announcement" :large="true" />
                </div>
            @else
                <div class="col-span-1">
                    <x-public.announcements.card :announcement="$announcement" />
                </div>
            @endif
        @empty
            <p class="col-span-3 font-serif text-dark-mid text-center py-16">
                {{ __('public/announcements.empty') }}
            </p>
        @endforelse
    </div>

    @if($announcements->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $announcements->links('pagination::tailwind') }}
        </div>
    @endif
</div>
