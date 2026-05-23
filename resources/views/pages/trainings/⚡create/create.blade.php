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

    <a href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}">← Retour</a>

    <form wire:submit="save">

        <div>
            <label>Titre</label>
            <input type="text" wire:model="form.title">
            @error('form.title') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Description</label>
            <input type="text" wire:model="form.description">
            @error('form.description') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model="form.details"></textarea>
            @error('form.details') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Contraintes</label>
            <textarea wire:model="form.constraints"></textarea>
            @error('form.constraints') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Date de début</label>
            <input type="datetime-local" wire:model="form.start_date">
            @error('form.start_date') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Date de fin</label>
            <input type="datetime-local" wire:model="form.end_date">
            @error('form.end_date') <p>{{ $message }}</p> @enderror
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
            @error('form.type') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Prix</label>
            <input type="number" wire:model="form.price" min="0">
            @error('form.price') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Nombre de participants</label>
            <input type="number" wire:model="form.participants" min="0">
            @error('form.participants') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Rue</label>
            <input type="text" wire:model="form.address">
            @error('form.address') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Numéro</label>
            <input type="text" wire:model="form.number">
            @error('form.number') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Ville</label>
            <input type="text" wire:model="form.city">
            @error('form.city') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Code postal</label>
            <input type="number" wire:model="form.postal_code">
            @error('form.postal_code') <p>{{ $message }}</p> @enderror
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
            @error('form.province') <p>{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend>Rôles autorisés à s'inscrire</legend>
            @foreach(UserRoles::cases() as $role)
                <label>
                    <input type="checkbox" wire:model="form.roles" value="{{ $role->value }}">
                    {{ $role->label() }}
                </label>
            @endforeach
            @error('form.roles') <p>{{ $message }}</p> @enderror
        </fieldset>

        @can('manage-training')
            <div>
                <label>Statut</label>
                <select wire:model="form.status">
                    @foreach(TrainingStatus::cases() as $status)
                        <option value="{{ $status->value }}">
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>
                @error('form.status') <p>{{ $message }}</p> @enderror
            </div>
        @endcan

        <div>
            <label>Bannière</label>
            @if($form->banner)
                <img src="{{ $form->banner->temporaryUrl() }}">
            @endif
            <input type="file" wire:model="form.banner" accept="image/*">
            @error('form.banner') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Galerie</label>
            <input type="file" wire:model="form.galeries" multiple accept="image/*">
            @error('form.galeries.*') <p>{{ $message }}</p> @enderror

            @if($form->galeries)
                <div class="grid grid-cols-6 gap-4">
                    @foreach($form->galeries as $galerie)
                            <img src="{{ $galerie->temporaryUrl() }}"
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit">Créer la formation</button>
    </form>
</div>
