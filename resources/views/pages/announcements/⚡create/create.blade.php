<div>
    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.announcements'), 'url' => route('public.announcements.index', ['locale' => app()->getLocale()])],
        ['label' => __('breadcrumbs.create_announcement')],
    ]" />
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"><-Retour</a>


    <form wire:submit="save">
        <div>
            <label>Titre</label>
            <input type="text" wire:model.live="form.title">
            @error('form.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Description courte</label>
            <input type="text" wire:model.live="form.description">
            @error('form.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Contenu</label>
            <textarea wire:model.live="form.content"></textarea>
            @error('form.content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model.live="form.details"></textarea>
            @error('form.details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{--<div>
             <label>Date de publication</label>
             <input type="datetime-local" wire:model.live="form.published_at">
             @error('form.published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>--}}

        <div>
            <label>Bannière</label>
            @if($form->banner)
                <img src="{{ $form->banner->temporaryUrl() }}">
            @endif
            <input type="file" wire:model.live="form.banner" accept="image/*">
            @error('form.banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Galerie</label>
            <input type="file" wire:model.live="form.galeries" multiple accept="image/*">
            @error('form.galeries.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if($form->galeries)
                <div class="grid grid-cols-6 gap-4">
                    @foreach($form->galeries as $galerie)
                        <img src="{{ $galerie->temporaryUrl() }}">
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit">Créer une actualité</button>
    </form>
</div>
