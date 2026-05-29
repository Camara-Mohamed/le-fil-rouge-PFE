@php
    use App\Enums\Provinces;
    use App\Enums\TrainingStatus;
    use App\Enums\TrainingTypes;
    use App\Enums\UserRoles;
@endphp

<div>
    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.trainings'), 'url' => route('public.trainings.index', ['locale' => app()->getLocale()])],
        ['label' => __('breadcrumbs.create_training')],
    ]" />
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}">← Retour</a>

    <form wire:submit="save">

        <div>
            <label>Titre</label>
            <input type="text" wire:model="form.title">
            @error('form.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Description</label>
            <input type="text" wire:model="form.description">
            @error('form.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Détails</label>
            <textarea wire:model="form.details"></textarea>
            @error('form.details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Contraintes</label>
            <textarea wire:model="form.constraints"></textarea>
            @error('form.constraints') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Date de début</label>
            <input type="datetime-local" wire:model="form.start_date">
            @error('form.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Date de fin</label>
            <input type="datetime-local" wire:model="form.end_date">
            @error('form.end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Type</label>
            <select wire:model="form.type">
                @foreach(TrainingTypes::cases() as $type)
                    <option value="{{ $type->value }}">
                        {{ $type->label() }}
                    </option>
                @endforeach
            </select>
            @error('form.type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Prix</label>
            <input type="number" wire:model="form.price" min="0">
            @error('form.price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Nombre de participants</label>
            <input type="number" wire:model="form.participants" min="0">
            @error('form.participants') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Rue</label>
            <input type="text" wire:model="form.address">
            @error('form.address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Numéro</label>
            <input type="text" wire:model="form.number">
            @error('form.number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Ville</label>
            <input type="text" wire:model="form.city">
            @error('form.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Code postal</label>
            <input type="number" wire:model="form.postal_code">
            @error('form.postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Province</label>
            <select wire:model="form.province">
                @foreach(Provinces::cases() as $province)
                    <option value="{{ $province->value }}">
                        {{ $province->label() }}
                    </option>
                @endforeach
            </select>
            @error('form.province') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <fieldset>
            <legend>Rôles autorisés à s'inscrire</legend>
            @foreach(UserRoles::cases() as $role)
                <label>
                    <input type="checkbox" wire:model="form.roles" value="{{ $role->value }}">
                    {{ $role->label() }}
                </label>
            @endforeach
            @error('form.roles') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </fieldset>

        @can('manage-training')
            <div>
                <label>Statut</label>
                <select wire:model="form.status">
                    @foreach(TrainingStatus::cases() as $status)
                        <option value="{{ $status->value }}">
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endcan

        <div>
            <label>Bannière</label>
            @if($form->banner)
                <img src="{{ $form->banner->temporaryUrl() }}">
            @endif
            <input type="file" wire:model="form.banner" accept="image/*">
            @error('form.banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Galerie</label>
            <input type="file" wire:model="form.galeries" multiple accept="image/*">
            @error('form.galeries.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if($form->galeries)
                <div class="grid grid-cols-6 gap-4">
                    @foreach($form->galeries as $galerie)
                        <img src="{{ $galerie->temporaryUrl() }}">
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit">Créer la formation</button>
    </form>
</div>
