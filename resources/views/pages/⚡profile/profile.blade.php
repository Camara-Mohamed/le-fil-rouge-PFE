@php
    use App\Enums\Diets;
    use App\Enums\Provinces;
    use App\Enums\DocumentTypes;

    $sizes    = config('avatar.sizes');
    $user     = auth()->user();
    $initials = strtoupper($user->first_name[0] . $user->last_name[0]);
@endphp

<div class="flex flex-col gap-8">
    <form wire:submit="saveAvatar">
        <div>
            @if($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover">
            @elseif($user->avatar_path)
                <a href="{{ asset('storage/avatars/originals/' . $user->avatar_path) }}" data-fancybox="avatar">
                    <img
                        src="{{ asset('storage/avatars/originals/' . $user->avatar_path) }}"
                        srcset="
            @foreach($sizes as $size)
                {{ asset('storage/' . sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']) . '/' . $user->avatar_path) }} {{ $size['width'] }}w,
            @endforeach
            "
                        alt="Avatar de {{ $user->fullName() }}"
                        class="w-32 h-32 rounded-full object-cover cursor-pointer"
                    >
                </a>
            @else
                <div
                    class="w-32 h-32 rounded-full bg-blue-500 text-white flex items-center justify-center text-3xl font-bold">
                    {{ $initials }}
                </div>
            @endif
        </div>

        @if($user->avatar_path)
            <button type="button" wire:click="deleteAvatar">Supprimer l'avatar</button>
        @endif

        <label>Changer l'avatar</label>
        <input type="file" wire:model="avatar" accept="image/*">
        @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit">Enregistrer</button>
    </form>

    @if(session('success'))
        <div class="text-green-500">{{ session('success') }}</div>
    @endif
    <form wire:submit="saveInfo">
        <div>
            <label>Prénom</label>
            <input type="text" wire:model="info.first_name">
            @error('info.first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Nom</label>
            <input type="text" wire:model="info.last_name">
            @error('info.last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Téléphone</label>
            <input type="text" wire:model="info.phone">
            @error('info.phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Date de naissance</label>
            <input type="date" wire:model="info.birth_date">
            @error('info.birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <form wire:submit="saveEmail">
        <div>
            <label>Email</label>
            <input type="email" wire:model="email.email">
            @error('email.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <form wire:submit="savePassword">
        <div x-data="{ show: false }">
            <label>Mot de passe actuel</label>
            <input type="password" :type="show ? 'text' : 'password'" wire:model="password.current_password">
            <button type="button" @click="show = !show">
                <span x-show="!show">Afficher</span>
                <span x-show="show">Cacher</span>
            </button>
            @error('password.current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div x-data="{ show: false }">
            <label>Nouveau mot de passe</label>
            <input type="password" :type="show ? 'text' : 'password'" wire:model="password.password">
            <button type="button" @click="show = !show">
                <span x-show="!show">Afficher</span>
                <span x-show="show">Cacher</span>
            </button>
            @error('password.password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <form wire:submit="saveAddress">
        <div>
            <label>Adresse</label>
            <input type="text" wire:model="address.address">
            @error('address.address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Numéro</label>
            <input type="text" wire:model="address.number">
            @error('address.number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Ville</label>
            <input type="text" wire:model="address.city">
            @error('address.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="province">Province</label>
            <select id="province" wire:model="address.province">
                @foreach(Provinces::cases() as $province)
                    <option value="{{ $province->value }}">
                        {{ $province->label() }}
                    </option>
                @endforeach
            </select>
            @error('address.province') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Code postal</label>
            <input type="text" wire:model="address.postal_code">
            @error('address.postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <form wire:submit="saveDiet">
        <div>
            <label>Régime</label>
            <select wire:model="diet.diet">
                @foreach(Diets::cases() as $diet)
                    <option value="{{ $diet->value }}">
                        {{ $diet->label() }}
                    </option>
                @endforeach
            </select>
            @error('diet.diet') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Allergies</label>
            <textarea wire:model="diet.allergies"></textarea>
            @error('diet.allergies') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Mettre à jour</button>
    </form>

    <div>
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <form wire:submit="uploadDocument">
            <div>
                <label>Fichier</label>
                <input type="file" wire:model="document.file">
                @error('document.file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Nom</label>
                <input type="text" wire:model="document.name">
                @error('document.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Type</label>
                <select wire:model="document.type">
                    @foreach(DocumentTypes::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
                @error('document.type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit">Ajouter</button>
        </form>

        @forelse($documents as $document)
            <div wire:key="document-{{ $document->id }}">
                <span>{{ $document->name }}</span>
                <span>{{ $document->type }}</span>
                <a
                    href="{{ Storage::disk('public')->url($document->path) }}"
                    data-fancybox="profile-document"
                    data-type="iframe"
                    data-width="1000"
                    data-height="900"
                >Voir</a>
                <button type="button" wire:click="openConfirmDeleteDocumentModal({{ $document->id }})">
                    Supprimer
                </button>
            </div>
        @empty
            <p>Aucun document.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('logout', ['locale'=>app()->getLocale()], ['locale'=>app()->getLocale()]) }}">
        @csrf

        <button type="submit">Déconnexion</button>

        <small>Tu ne peux pas supprimer ton compte.</small>
    </form>
</div>

// Informations Personnelles

// Mail

// MDP

// Adresse Physique

// Documents

// Avertissement

// Logout
