@php use App\Enums\Diets;use App\Enums\Provinces; @endphp
<div>
    <p>{{ auth()->user()->fullName() }}</p>

    <p>{{ auth()->user()->role->value }}</p>

    <form wire:submit="save">
        <div>
            <label>Avatar</label>
            <input type="file" wire:model="avatar">
        </div>

        <div>
            <label>Prénom</label>
            <input type="text" wire:model="form.first_name">
        </div>

        <div>
            <label>Nom</label>
            <input type="text" wire:model="form.last_name">
        </div>

        <div>
            <label>Email</label>
            <input type="email" wire:model="form.email">
        </div>

        <div>
            <label>Téléphone</label>
            <input type="text" wire:model="form.phone">
        </div>

        <div>
            <label>Date de naissance</label>
            <input type="date" wire:model="form.birth_date">
        </div>

        <div>
            <label>Adresse</label>
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
            <label for="province">Province</label>
            <select id="province" wire:model="form.province">
                @foreach(Provinces::cases() as $province)
                    <option value="{{ $province->value }}">
                        {{ $province->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Code postal</label>
            <input type="text" wire:model="form.postal_code">
        </div>

        <div>
            <label>Régime</label>
            <select wire:model="form.diet">
                @foreach(Diets::cases() as $diet)
                    <option value="{{ $diet->value }}">
                        {{ $diet->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Allergies</label>
            <textarea wire:model="form.allergies"></textarea>
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">Déconnexion</button>

        <small>Tu ne peux pas supprimer ton compte demande à l'administrateur pour le faire.</small>
    </form>

    // Informations Personnelles

    // Mail

    // MDP

    // Adresse Physique

    // Documents

    // Avertissement

    // Logout

</div>
