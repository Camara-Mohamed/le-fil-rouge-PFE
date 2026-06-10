<section aria-labelledby="section-commentaires" wire:poll.10s class="flex flex-col gap-12">

    <h2 id="section-commentaires" class="font-sans font-black text-5xl text-dark capitalize">
        {{ __('livewire/comments.title', ['count' => $comments->count()]) }}
    </h2>

    <div class="bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] px-6 py-8 flex flex-col gap-8">

        <form wire:submit="save" class="flex items-start gap-3">

            @auth
                @if(auth()->user()->avatar_path)
                    <img src="{{ Storage::url('avatars/originals/' . auth()->user()->avatar_path) }}"
                         alt="{{ auth()->user()->fullName() }}"
                         class="size-10 rounded-full object-cover shrink-0">
                @else
                    <div class="size-10 rounded-full bg-bg-dark shrink-0 flex items-center justify-center font-sans font-bold text-sm text-dark-mid" aria-hidden="true">
                        {{ strtoupper(auth()->user()->first_name[0] . auth()->user()->last_name[0]) }}
                    </div>
                @endif
            @endauth

            {{-- Champ --}}
            <div class="flex-1 flex flex-col items-end gap-2">
                <div class="w-full flex flex-col gap-2">
                    <label for="comment-content" class="sr-only">{{ __('livewire/comments.write_label') }}</label>
                    <textarea id="comment-content"
                              wire:model="form.content"
                              rows="6"
                              placeholder="{{ __('livewire/comments.placeholder') }}"
                              class="w-full px-6 py-4 bg-bg border border-bg-dark rounded-lg font-sans text-sm text-dark placeholder:text-dark-light resize-none focus:outline-none focus:border-red transition duration-200"></textarea>
                    @error('form.content')
                        <span class="self-start font-sans text-sm text-danger">{{ $message }}</span>
                    @enderror

                    <label class="flex items-center gap-2 cursor-pointer self-start">
                        <input type="file" wire:model="form.document" class="hidden" id="comment-document-input" />
                        <span class="font-sans text-sm font-medium text-red underline hover:text-red-mid transition duration-200">
                            {{ __('livewire/comments.add_document') }}
                        </span>
                    </label>
                    @if($form->document)
                        <span class="self-start font-sans text-xs text-dark-mid">
                            {{ $form->document->getClientOriginalName() }}
                        </span>
                    @endif
                    @error('form.document')
                        <span class="self-start font-sans text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                        class="px-8 py-4 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ __('livewire/comments.submit') }}
                </button>
            </div>

        </form>

        {{-- Liste des commentaires --}}
        <div class="flex flex-col gap-12">
            @forelse($comments as $comment)
                <div wire:key="comment-{{ $comment->id }}" class="flex flex-col gap-1">

                    <p class="font-sans text-sm font-medium text-dark-mid uppercase ml-16">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>

                    <div class="flex items-start gap-6">

                        {{-- Avatar --}}
                        @if($comment->user->avatar_path)
                            <img src="{{ Storage::url('avatars/originals/' . $comment->user->avatar_path) }}"
                                 alt="{{ $comment->user->fullName() }}"
                                 class="size-10 rounded-full object-cover shrink-0">
                        @else
                            <div class="size-10 rounded-full bg-bg-dark shrink-0 flex items-center justify-center font-sans font-bold text-sm text-dark-mid" aria-hidden="true">
                                {{ strtoupper($comment->user->first_name[0] . $comment->user->last_name[0]) }}
                            </div>
                        @endif

                        {{-- Contenu --}}
                        <div class="flex-1 flex flex-col gap-4">

                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex flex-col gap-1">
                                        <p class="font-sans font-black text-base text-dark">
                                            {{ $comment->user->fullName() }}
                                        </p>
                                        <p class="font-serif text-sm text-dark-mid">
                                            {{ $comment->user->email }}
                                        </p>
                                    </div>
                                    <span class="shrink-0 px-4 py-0.5 bg-warning-bg border border-warning rounded-2xl font-sans text-sm font-medium leading-6 text-red">
                                        {{ $comment->user->role->label() }}
                                    </span>
                                </div>

                                <p class="font-serif text-base leading-6 text-dark">
                                    {{ $comment->content }}
                                </p>
                            </div>

                            <div class="flex justify-between items-center gap-4">
                                @if($comment->document)
                                    <a href="{{ config('filesystems.default') === 's3' ? Storage::disk('s3')->temporaryUrl($comment->document, now()->addMinutes(30)) : Storage::url($comment->document) }}"
                                       data-fancybox="comment-document-{{ $comment->id }}"
                                       data-type="iframe"
                                       data-width="900"
                                       data-height="700"
                                       class="font-sans text-sm font-medium text-red underline hover:text-red-mid transition duration-200">
                                        {{ __('livewire/comments.view_document') }}
                                    </a>
                                @else
                                    <span></span>
                                @endif

                                @can('delete', $comment)
                                    <button wire:click="openDeleteModal({{ $comment->id }})"
                                            class="font-sans text-sm font-medium text-dark underline hover:text-danger transition duration-200">
                                        {{ __('livewire/comments.delete') }}
                                    </button>
                                @endcan
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <p class="font-serif text-dark-mid text-center py-8">{{ __('livewire/comments.empty') }}</p>
            @endforelse
        </div>

    </div>

</section>
