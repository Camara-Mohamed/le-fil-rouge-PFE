<div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' =>
        $announcement]) }}">Page de l'actualité : {{ $announcement->title }}</a>

    <form wire:submit="save">
        <div>
            <label>Titre</label>
            <input type="text" wire:model="form.title">
            @error('form.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Description courte</label>
            <input type="text" wire:model="form.description">
            @error('form.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Contenu</label>
            <textarea wire:model="form.content"></textarea>
            @error('form.content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model="form.details"></textarea>
            @error('form.details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Date de publication</label>
            <input type="date" wire:model="form.published_at">
            @error('form.published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Bannière</label>
            @if($announcement->banner)
                <img src="{{ asset('storage/' . $announcement->banner) }}" class="w-32 h-32 object-cover">
            @endif
            <input type="file" wire:model="form.banner" accept="image/*">
            @error('form.banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Enregistrer</button>
    </form>

    @can('delete', $announcement)
        <button wire:click="delete" wire:confirm="Supprimer l'actualité ?" type="button">Supprimer</button>
    @endcan
</div>
