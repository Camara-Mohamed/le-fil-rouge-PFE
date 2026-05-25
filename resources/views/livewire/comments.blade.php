<div wire:poll.10s>

    <h3>Les commentaires :</h3>

    @forelse($comments as $comment)
        <div class="flex flex-col gap-4">
            <div>
                <h4 class="{{ $comment->is_admin ? 'text-red-mid' : '' }}">{{ $comment->user->fullName() }}</h4>
                <p>{{ $comment->created_at->diffForHumans() }}</p>
            </div>

            <p>{{ $comment->content }}</p>

            @if($comment->document)
                <a href="{{ asset('storage/' . $comment->document) }}" target="_blank">
                    Voir le document
                </a>
            @endif

            @can('delete', $comment)
                <button wire:click="delete({{ $comment->id }})" wire:confirm="Supprimer ce commentaire ?">
                    Supprimer
                </button>
            @endcan
        </div>
    @empty
        <p>Aucun commentaire</p>
    @endforelse

    @auth
        <form wire:submit="save" class="flex flex-col gap-4">

            <div>
                <label>Commentaire</label>
                <textarea wire:model="form.content" rows="3"></textarea>
                @error('form.content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Document</label>
                <input type="file" wire:model="form.document">
                @error('form.document') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit">Envoyer</button>

        </form>
    @endauth

</div>
