@php
    $scrollTo = $scrollTo ?? 'body';
    $scrollIntoViewJsSnippet = $scrollTo !== false
        ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
        : '';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-4">

        <div class="flex items-center gap-1.5">

            {{-- Précédent --}}
            @if ($paginator->onFirstPage())
                <span class="h-9 px-3 flex items-center gap-1.5 rounded-lg bg-bg border border-bg-mid text-dark-light cursor-not-allowed font-sans text-sm font-medium select-none"
                      aria-disabled="true">
                    <x-icons.chevron-left class="size-3.5" />
                    <span class="hidden sm:inline">{{ __('pagination.previous') }}</span>
                </span>
            @else
                <button
                    type="button"
                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    wire:loading.attr="disabled"
                    class="h-9 px-3 flex items-center gap-1.5 rounded-lg bg-bg border border-bg-mid text-dark hover:bg-bg-mid transition duration-200 font-sans text-sm font-medium"
                    aria-label="{{ __('pagination.previous') }}"
                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after">
                    <x-icons.chevron-left class="size-3.5" />
                    <span class="hidden sm:inline">{{ __('pagination.previous') }}</span>
                </button>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 flex items-center justify-center font-sans text-sm text-dark-light select-none">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="w-9 h-9 flex items-center justify-center rounded-lg bg-red text-white font-sans font-bold text-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button
                                    type="button"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-bg border border-bg-mid text-dark font-sans font-medium text-sm hover:bg-bg-mid transition duration-200"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </button>
                            @endif
                        </span>
                    @endforeach
                @endif
            @endforeach

            {{-- Suivant --}}
            @if ($paginator->hasMorePages())
                <button
                    type="button"
                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    wire:loading.attr="disabled"
                    class="h-9 px-3 flex items-center gap-1.5 rounded-lg bg-bg border border-bg-mid text-dark hover:bg-bg-mid transition duration-200 font-sans text-sm font-medium"
                    aria-label="{{ __('pagination.next') }}"
                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after">
                    <span class="hidden sm:inline">{{ __('pagination.next') }}</span>
                    <x-icons.chevron-right class="size-3.5" />
                </button>
            @else
                <span class="h-9 px-3 flex items-center gap-1.5 rounded-lg bg-bg border border-bg-mid text-dark-light cursor-not-allowed font-sans text-sm font-medium select-none"
                      aria-disabled="true">
                    <span class="hidden sm:inline">{{ __('pagination.next') }}</span>
                    <x-icons.chevron-right class="size-3.5" />
                </span>
            @endif

        </div>

        @if ($paginator->firstItem())
            <p class="font-serif text-sm text-dark-mid whitespace-nowrap">
                {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
                <span class="text-dark-mid mx-0.5">{{ __('pagination.of') }}</span>
                <span class="font-medium text-dark">{{ $paginator->total() }}</span>
            </p>
        @endif

    </nav>
@endif
