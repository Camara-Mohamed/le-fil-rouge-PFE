<div>

    <x-public.hero :title="$announcement->title" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <livewire:widgets::breadcrumb :items="[
                ['label' => __('breadcrumbs.announcements'), 'url' => route('public.announcements.index', ['locale' => app()->getLocale()])],
                ['label' => $announcement->title, 'url' => route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement])],
                ['label' => __('breadcrumbs.edit')],
            ]" />
        </div>

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Informations --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Informations</h2>
                <x-public.form.input label="Titre" name="form.title" wire:model.live="form.title" maxlength="255" required />
                <x-public.form.input label="Description courte" name="form.description" wire:model.live="form.description" maxlength="255" required />
            </section>

            {{-- Contenu --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Contenu</h2>
                <x-public.form.textarea label="Contenu" name="form.content" wire:model.live="form.content" :rows="8" required />
                <x-public.form.textarea label="Détails" name="form.details" wire:model.live="form.details" :rows="5" />
            </section>

            {{-- Images --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Images</h2>

                {{-- Bannière --}}
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-bold text-base text-dark">Bannière</span>
                    @if($announcement->banner && !$form->banner)
                        <img src="{{ Storage::url($announcement->banner) }}" alt="{{ $announcement->title }}" class="w-full h-48 object-cover rounded-xl" />
                    @endif
                    @if($form->banner)
                        <img src="{{ $form->banner->temporaryUrl() }}" alt="Image temporaire" class="w-full h-48 object-cover rounded-xl" />
                    @endif
                    <label class="flex items-center gap-3 px-4 py-3 bg-bg border-2 border-dashed border-dark-light rounded-xl cursor-pointer hover:border-dark transition">
                        <span class="font-serif text-sm text-dark-mid">{{ $announcement->banner ? 'Changer la bannière…' : 'Choisir une bannière…' }}</span>
                        <input type="file" wire:model.live="form.banner" accept="image/*" class="sr-only">
                    </label>
                    <p class="font-serif text-xs text-dark-mid">JPG, PNG, GIF ou WEBP - 2 Mo max</p>
                    @error('form.banner')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                {{-- Galerie --}}
                @if($announcement->galeries->count())
                    <div class="flex flex-col gap-3">
                        <span class="font-sans font-bold text-base text-dark">Galerie</span>
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($announcement->galeries as $galerie)
                                <div wire:key="galerie-{{ $galerie->id }}" class="relative group">
                                    <img src="{{ Storage::url($galerie->path) }}" alt="{{ $announcement->title }}" class="w-full h-24 object-cover rounded-lg" />
                                    <button type="button"
                                            wire:click="openConfirmDeleteGalerieModal({{ $galerie->id }})"
                                            class="absolute inset-0 flex items-center justify-center bg-dark/50 text-white font-sans text-xs font-bold rounded-lg opacity-0 group-hover:opacity-100 transition">
                                        Supprimer
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Nouvelle galerie --}}
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-bold text-base text-dark">Nouvelle galerie</span>
                    @if($form->galeries)
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($form->galeries as $index => $galerie)
                                <img wire:key="galerie-preview-{{ $index }}" src="{{ $galerie->temporaryUrl() }}" alt="Image temporaire" class="w-full h-24 object-cover rounded-lg" />
                            @endforeach
                        </div>
                    @endif
                    <label class="flex items-center gap-3 px-4 py-3 bg-bg border-2 border-dashed border-dark-light rounded-xl cursor-pointer hover:border-dark transition">
                        <span class="font-serif text-sm text-dark-mid">Ajouter des images à la galerie…</span>
                        <input type="file" wire:model.live="form.galeries" accept="image/*" multiple class="sr-only">
                    </label>
                    <p class="font-serif text-xs text-dark-mid">JPG, PNG, GIF ou WEBP - 2 Mo max par image</p>
                    @error('form.galeries.*')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </section>

            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                Enregistrer
            </button>

        </form>

        @can('delete', $announcement)
            <button type="button" wire:click="openConfirmDeleteModal"
                    class="w-full py-4 bg-white border-2 border-danger text-danger font-sans font-bold text-base rounded-lg hover:bg-danger-bg transition duration-200">
                Supprimer l'actualité
            </button>
        @endcan

    </div>
</div>
