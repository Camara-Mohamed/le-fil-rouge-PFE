<div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"><-Retour</a>


    <form wire:submit="save">
        <div>
            <label>Titre</label>
            <input type="text" wire:model="form.title">
        </div>

        <div>
            <label>Description courte</label>
            <input type="text" wire:model="form.description">
        </div>

        <div>
            <label>Contenu</label>
            <textarea wire:model="form.content"></textarea>
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model="form.details"></textarea>
        </div>

        <div>
            <label>Date de publication</label>
            <input type="date" wire:model="form.published_at">
        </div>

        <div>
            <label>Bannière</label>
            <input type="file" wire:model="form.banner" accept="image/*">
        </div>

        <button type="submit">Créer une actualité</button>
    </form>
</div>
