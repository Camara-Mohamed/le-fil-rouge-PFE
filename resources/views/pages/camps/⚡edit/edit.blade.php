@php
    use App\Enums\Provinces;
    use App\Enums\CampStatus;
    use App\Enums\CampTypes;
    use App\Enums\UserRoles;
@endphp

<div>

    <x-public.hero :title="$camp->title" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <livewire:widgets::breadcrumb :items="[
                ['label' => __('breadcrumbs.camps'), 'url' => route('public.camps.index', ['locale' => app()->getLocale()])],
                ['label' => $camp->title, 'url' => route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp])],
                ['label' => __('breadcrumbs.edit')],
            ]" />
        </div>

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Informations --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Informations générales</h2>

                <div class="flex flex-col gap-4">
                    <x-public.form.input label="Titre" name="form.title" wire:model.live="form.title" maxlength="255" required />
                    <x-public.form.input label="Description courte" name="form.description" wire:model.live="form.description" maxlength="1000" required />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-public.form.select
                            label="Type"
                            name="form.type"
                            :options="CampTypes::cases()"
                            wire:model.live="form.type"
                            required
                        />
                        <x-public.form.input label="Participants max" name="form.participants" wire:model.live="form.participants" type="number" min="1" />
                        @if(auth()->user()->isAdmin())
                            <x-public.form.select
                                label="Statut"
                                name="form.status"
                                :options="CampStatus::cases()"
                                wire:model.live="form.status"
                                required
                            />
                        @endif
                    </div>
                </div>
            </section>

            {{-- Contenu --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Contenu</h2>
                <x-public.form.textarea label="Détails / Objectifs" name="form.details" wire:model.live="form.details" :rows="5" />
                <x-public.form.textarea label="Contraintes" name="form.constraints" wire:model.live="form.constraints" :rows="4" />
            </section>

            {{-- Dates --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Dates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-public.form.input label="Date de début" name="form.start_date" wire:model.live="form.start_date" type="datetime-local" required />
                    <x-public.form.input label="Date de fin" name="form.end_date" wire:model.live="form.end_date" type="datetime-local" required />
                </div>
            </section>

            {{-- Adresse --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Localisation</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-public.form.input label="Rue" name="form.address" wire:model.live="form.address" maxlength="255" />
                    </div>
                    <x-public.form.input label="Numéro" name="form.number" wire:model.live="form.number" maxlength="20" />
                    <x-public.form.input label="Code postal" name="form.postal_code" wire:model.live="form.postal_code" type="number" min="0" />
                    <x-public.form.input label="Ville" name="form.city" wire:model.live="form.city" maxlength="255" />
                    <x-public.form.select
                        label="Province"
                        name="form.province"
                        :options="Provinces::cases()"
                        wire:model.live="form.province"
                        required
                    />
                </div>
            </section>

            {{-- Rôles --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-4">
                <h2 class="font-sans font-bold text-xl text-dark">Rôles autorisés à s'inscrire</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach(UserRoles::registrable() as $role)
                        <label class="flex items-center gap-2 px-4 py-2 bg-bg rounded-lg cursor-pointer hover:bg-bg-mid transition">
                            <input type="checkbox" wire:model.live="form.roles" value="{{ $role->value }}" class="size-4 accent-red">
                            <span class="font-serif text-sm text-dark">{{ $role->label() }}</span>
                        </label>
                    @endforeach
                </div>
                @error('form.roles')
                    <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                        <p class="font-serif text-sm text-danger">{{ $message }}</p>
                    </div>
                @enderror
            </section>

            {{-- Images --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">Images</h2>

                {{-- Bannière --}}
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-bold text-base text-dark">Bannière</span>
                    @if($camp->banner && !$form->banner)
                        <img src="{{ Storage::url($camp->banner) }}" alt="{{ $camp->title }}" class="w-full h-48 object-cover rounded-xl" />
                    @endif
                    @if($form->banner)
                        <img src="{{ $form->banner->temporaryUrl() }}" alt="Image temporaire" class="w-full h-48 object-cover rounded-xl" />
                    @endif
                    <label class="flex items-center gap-3 px-4 py-3 bg-bg border-2 border-dashed border-dark-light rounded-xl cursor-pointer hover:border-dark transition">
                        <span class="font-serif text-sm text-dark-mid">{{ $camp->banner ? 'Changer la bannière…' : 'Choisir une bannière…' }}</span>
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
                @if($camp->galeries->count())
                    <div class="flex flex-col gap-3">
                        <span class="font-sans font-bold text-base text-dark">Galerie</span>
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($camp->galeries as $galerie)
                                <div wire:key="galerie-{{ $galerie->id }}" class="relative group">
                                    <img src="{{ Storage::url($galerie->path) }}" alt="{{ $camp->title }}" class="w-full h-24 object-cover rounded-lg" />
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
                Mettre à jour
            </button>

        </form>

        @can('delete', $camp)
            <button type="button" wire:click="openConfirmDeleteModal"
                    class="w-full py-4 bg-white border-2 border-danger text-danger font-sans font-bold text-base rounded-lg hover:bg-danger-bg transition duration-200">
                Supprimer le stage
            </button>
        @endcan

    </div>
</div>
