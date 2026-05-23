@php
    use App\Enums\Provinces;
    use App\Enums\TrainingStatus;
    use App\Enums\TrainingTypes;
    use App\Enums\UserRoles;
@endphp

<div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training]) }}">
        ← Retour {{ $training->title }}
    </a>

    <form wire:submit="save">

        <div>
            <label>Titre</label>
            <input type="text" wire:model="form.title">
        </div>

        <div>
            <label>Description</label>
            <input type="text" wire:model="form.description">
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model="form.details"></textarea>
        </div>

        <div>
            <label>Contraintes</label>
            <textarea wire:model="form.constraints"></textarea>
        </div>

        <div>
            <label>Date de début</label>
            <input type="datetime-local" wire:model="form.start_date">
        </div>

        <div>
            <label>Date de fin</label>
            <input type="datetime-local" wire:model="form.end_date">
        </div>

        <div>
            <label>Type</label>
            <select wire:model="form.type">
                @foreach(TrainingTypes::cases() as $type)
                    <option value="{{ $type->value }}">
                        {{ $type->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Prix</label>
            <input type="number" wire:model="form.price" min="0">
        </div>

        <div>
            <label>Participants</label>
            <input type="number" wire:model="form.participants" min="1">
        </div>

        <div>
            <label>Rue</label>
            <input type="text" wire:model="form.address">
        </div>

        <div>
            <label>Numéro</label>
            <input type="text" wire:model="form.number">
        </div>

        <div>
            <label>Ville</label>
            <input type="text" wire:model="form.city">
        </div>

        <div>
            <label>Code postal</label>
            <input type="number" wire:model="form.postal_code">
        </div>

        <div>
            <label>Province</label>
            <select wire:model="form.province">
                @foreach(Provinces::cases() as $province)
                    <option value="{{ $province->value }}">
                        {{ $province->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <fieldset>
            <legend>Rôles autorisés</legend>
            @foreach(UserRoles::cases() as $role)
                <label>
                    <input type="checkbox" wire:model="form.roles" value="{{ $role->value }}">
                    {{ $role->label() }}
                </label>
            @endforeach
        </fieldset>

        @if(auth()->user()->isAdmin())
            <div>
                <label>Statut</label>
                <select wire:model="form.status">
                    @foreach(TrainingStatus::cases() as $status)
                        <option value="{{ $status->value }}">
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
            <label>Bannière</label>
            @if($training->banner)
                <img src="{{ asset('storage/' . $training->banner) }}" class="w-32 h-32 object-cover">
            @endif
            <input type="file" wire:model="form.banner" accept="image/*">
        </div>

        <div>
            <label>Galerie</label>

            @if($training->galeries)
                @foreach($training->galeries as $galerie)
                    <div class="grid grid-cols-6 gap-4">
                        <img src="{{ asset('storage/'.$galerie->path) }}">
                        <button
                            type="button"
                            wire:click="deleteGalerie({{ $galerie->id }})"
                            wire:confirm="Supprimer"
                        >Supprimer
                        </button>
                    </div>
                @endforeach
            @endif

            <input type="file" wire:model="form.galeries" multiple accept="image/*">
            @error('form.galeries.*') <p>{{ $message }}</p> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    @can('delete', $training)
        <button wire:click="delete" wire:confirm="Supprimer la formation ?" type="button">
            Supprimer
        </button>
    @endcan
</div>
