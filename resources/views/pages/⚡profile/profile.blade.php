@php
    use App\Enums\Diets;
    use App\Enums\Provinces;
    use App\Enums\DocumentTypes;
    use App\Enums\UserStatus;

    $sizes    = config('avatar.sizes');
    $user     = auth()->user();
    $initials = strtoupper($user->first_name[0] . $user->last_name[0]);
@endphp

<div>

    <x-public.hero title="{{ __('navigation.profile') }}" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

    {{-- Profil --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Profil</h2>

        <div class="grid grid-cols-1 md:grid-cols-[2fr_3fr] gap-8 items-start">

            <form wire:submit="saveAvatar" class="flex flex-col items-center gap-4 p-4 bg-bg rounded-xl">

                @if($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Aperçu"
                         class="size-28 rounded-full object-cover ring-4 ring-white shadow">
                @elseif($user->avatar_path)
                    <a href="{{ Storage::url('avatars/originals/' . $user->avatar_path) }}" data-fancybox="avatar">
                        <img src="{{ Storage::url('avatars/originals/' . $user->avatar_path) }}"
                             srcset="@foreach($sizes as $size){{ Storage::url(sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']) . '/' . $user->avatar_path) }} {{ $size['width'] }}w,@endforeach"
                             alt="Avatar de {{ $user->fullName() }}"
                             class="size-28 rounded-full object-cover ring-4 ring-white shadow cursor-pointer">
                    </a>
                @else
                    <div class="size-28 rounded-full bg-bg-dark ring-4 ring-white shadow flex items-center justify-center font-sans font-black text-2xl text-dark">
                        {{ $initials }}
                    </div>
                @endif

                <p class="font-sans font-black text-base text-dark text-center">{{ $user->fullName() }}</p>

                <div class="flex flex-wrap justify-center gap-2">
                    <x-public.badge variant="info">{{ $user->role->label() }}</x-public.badge>
                    @php
                        $statusVariant = match($user->status) {
                            UserStatus::COMPLETE  => 'success',
                            UserStatus::PENDING   => 'warning',
                           UserStatus::INCOMPLETE => 'danger',
                            default                          => 'danger',
                        };
                    @endphp
                    <x-public.badge :variant="$statusVariant">{{ $user->status->label() }}</x-public.badge>
                </div>

                <div class="flex flex-col items-center gap-2 w-full pt-2 border-t border-bg-dark">
                    <label for="avatar-input"
                           class="w-full py-1.5 rounded-lg border-2 border-dark-light text-dark font-sans font-medium text-sm cursor-pointer hover:border-dark transition text-center">
                        Changer la photo
                        <input id="avatar-input" type="file" wire:model.live="avatar"
                               accept="image/jpeg,image/png,image/gif,image/webp" class="sr-only">
                    </label>

                    @error('avatar')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger w-full">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror

                    @if($user->avatar_path)
                        <button type="button" wire:click="deleteAvatar"
                                class="font-sans font-medium text-xs text-red underline hover:text-red-mid transition">
                            Supprimer la photo
                        </button>
                    @endif

                    @if($avatar)
                        <button type="submit"
                                class="w-full py-2 bg-red text-white font-sans font-bold text-sm rounded-lg hover:bg-red-mid transition">
                            Enregistrer
                        </button>
                    @endif
                </div>
            </form>

            {{-- Informations personnelles --}}
            <form wire:submit="saveInfo" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <x-public.form.input label="Prénom" name="info.first_name" wire:model.live="info.first_name" required />
                    <x-public.form.input label="Nom" name="info.last_name" wire:model.live="info.last_name" required />
                </div>
                <x-public.form.input label="Téléphone" name="info.phone" wire:model.live="info.phone" type="tel" />
                <x-public.form.input label="Date de naissance" name="info.birth_date" wire:model.live="info.birth_date" type="date" />
                <button type="submit"
                        class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                    Enregistrer
                </button>
            </form>

        </div>
    </section>

    {{-- Email --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Adresse e-mail</h2>

        <form wire:submit.prevent="saveEmail" class="flex flex-col gap-6">
            <x-public.form.input label="E-mail" name="email.email" wire:model.live="email.email" type="email" required />
            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                Enregistrer
            </button>
        </form>
    </section>

    {{-- Mot de passe --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Mot de passe</h2>

        <form wire:submit="savePassword" class="flex flex-col gap-6">
            <div class="flex flex-col gap-4" x-data="{ show1: false, show2: false }">

                <div class="flex flex-col gap-2">
                    <label for="current-password" class="font-sans font-bold text-base text-dark">Mot de passe actuel</label>
                    <div class="relative">
                        <input id="current-password" type="password" :type="show1 ? 'text' : 'password'"
                               wire:model.live="password.current_password"
                               class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark transition duration-200">
                        <button type="button" @click="show1 = !show1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition">
                            <x-icons.eye x-show="!show1" class="size-5" fill="fill-current" />
                            <x-icons.eye-slash x-show="show1" class="size-5" fill="fill-current" />
                        </button>
                    </div>
                    @error('password.current_password')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="new-password" class="font-sans font-bold text-base text-dark">Nouveau mot de passe</label>
                    <div class="relative">
                        <input id="new-password" type="password" :type="show2 ? 'text' : 'password'"
                               wire:model.live="password.password"
                               class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark transition duration-200">
                        <button type="button" @click="show2 = !show2"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition">
                            <x-icons.eye x-show="!show2" class="size-5" fill="fill-current" />
                            <x-icons.eye-slash x-show="show2" class="size-5" fill="fill-current" />
                        </button>
                    </div>
                    @error('password.password')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

            </div>
            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                Enregistrer
            </button>
        </form>
    </section>

    {{-- Adresse --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Adresse</h2>

        <form wire:submit="saveAddress" class="flex flex-col gap-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <x-public.form.input label="Rue" name="address.address" wire:model.live="address.address" />
                </div>
                <x-public.form.input label="Numéro" name="address.number" wire:model.live="address.number" />
                <x-public.form.input label="Ville" name="address.city" wire:model.live="address.city" />
                <x-public.form.input label="Code postal" name="address.postal_code" wire:model.live="address.postal_code" />
                <x-public.form.select label="Province" name="address.province"
                    :options="Provinces::cases()" wire:model.live="address.province"
                    :error="$errors->first('address.province')" />
            </div>
            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                Enregistrer
            </button>
        </form>
    </section>

    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Régime alimentaire</h2>

        <form wire:submit="saveDiet" class="flex flex-col gap-6">
            <x-public.form.select label="Régime" name="diet.diet"
                :options="Diets::cases()" wire:model.live="diet.diet"
                :error="$errors->first('diet.diet')" />
            <x-public.form.textarea label="Allergies" name="diet.allergies"
                wire:model.live="diet.allergies"
                placeholder="Décrivez vos allergies si vous en avez…"
                :rows="4" />
            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                Enregistrer
            </button>
        </form>
    </section>

    {{-- Documents --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-8">
        <h2 class="font-sans font-black text-3xl text-dark">Documents</h2>

        <div class="flex flex-col gap-10">

            {{-- Zone --}}
            <form wire:submit="uploadDocument" x-data="{ dragging: false, fileName: null }">
                <div class="flex flex-col gap-4">

                    <div class="relative h-52">
                        <div class="h-full rounded-xl flex flex-col justify-center items-center gap-3 pointer-events-none transition-all duration-200"
                             :class="dragging
                                 ? 'border-2 border-dashed border-red bg-red-light scale-[1.01]'
                                 : 'border-2 border-dashed border-dark-light bg-bg hover:border-dark'">
                            <div class="flex items-center justify-center size-12 rounded-full bg-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"
                                     class="size-6 fill-current"
                                     :class="dragging ? 'text-red' : 'text-dark-mid'">
                                    <path d="M240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H80a8,8,0,0,1,0,16H32v64H224V136H176a8,8,0,0,1,0-16h48A16,16,0,0,1,240,136ZM85.66,77.66,120,43.31V128a8,8,0,0,0,16,0V43.31l34.34,34.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,77.66Z"/>
                                </svg>
                            </div>
                            <div class="text-center px-4">
                                <p class="font-sans font-bold text-sm"
                                   :class="dragging ? 'text-red' : 'text-dark'">
                                    Glisser un fichier ici
                                </p>
                                <p class="font-serif text-sm text-dark-mid">ou <span class="text-red underline font-medium">parcourir</span></p>
                            </div>
                        </div>
                        <input type="file"
                               wire:model.live="document.file"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               @dragenter="dragging = true"
                               @dragleave="dragging = false"
                               @drop="dragging = false; fileName = $event.dataTransfer.files[0]?.name ?? null"
                               @change="fileName = $event.target.files[0]?.name ?? null">
                    </div>

                    <div x-show="fileName" x-transition
                         class="flex items-center gap-3 px-4 py-3 bg-success-bg border-l-[3px] border-success rounded-r-lg">
                        <x-icons.check class="size-4 text-success shrink-0" fill="fill-current" />
                        <p class="font-sans text-sm font-medium text-success" x-text="fileName"></p>
                    </div>

                    @error('document.file')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror

                    <div class="flex flex-col gap-4">
                        <x-public.form.input label="Nom du document" name="document.name"
                            wire:model.live="document.name" placeholder="Ex : Casier judiciaire" />
                        <x-public.form.select label="Type" name="document.type"
                            :options="DocumentTypes::cases()" wire:model.live="document.type"
                            :error="$errors->first('document.type')" />
                        <button type="submit"
                                class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                            Envoyer le document
                        </button>
                    </div>

                </div>
            </form>

            {{-- Liste des documents --}}
            @if($documents->isNotEmpty())
                <div class="pt-6 border-t border-bg-dark flex flex-col gap-3">
                    @foreach($documents as $document)
                        <div wire:key="document-{{ $document->id }}"
                             class="px-6 py-4 bg-bg rounded-lg flex items-center justify-between gap-4">
                            <p class="font-sans font-bold text-base text-dark">{{ $document->name }}</p>
                            <div class="flex items-center gap-4 shrink-0">
                                <a href="{{ config('filesystems.default') === 's3' ? Storage::disk('s3')->temporaryUrl($document->path, now()->addMinutes(30)) : Storage::url($document->path) }}"
                                   data-fancybox="profile-document"
                                   data-type="iframe"
                                   data-width="1000"
                                   data-height="900"
                                   class="font-sans font-medium text-sm text-dark underline hover:text-red transition">
                                    Voir
                                </a>
                                <button type="button"
                                        wire:click="openConfirmDeleteDocumentModal({{ $document->id }})"
                                        class="font-sans font-medium text-sm text-red underline hover:text-red-mid transition">
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    {{-- Info documents --}}
    <div class="px-6 py-4 bg-white rounded-tl-sm rounded-bl-sm shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] border-l-[6px] border-red flex flex-col gap-2">
        <p class="font-sans font-black text-base text-dark">{{ __('pages/profile.documents_info_title') }}</p>
        <p class="font-serif font-medium text-base text-dark">{{ __('pages/profile.documents_info_desc') }}</p>
    </div>

    {{-- Déconnexion --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex items-center justify-between gap-4" aria-label="Déconnexion">
        <div class="flex flex-col gap-1">
            <p class="font-sans font-bold text-base text-dark">Se déconnecter</p>
            <p class="font-serif text-sm text-dark-mid">Vous ne pouvez pas supprimer votre compte.</p>
        </div>
        <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
            @csrf
            <x-forms.button type="submit" class="text-danger border-danger hover:bg-danger hover:text-white">
                Déconnexion
            </x-forms.button>
        </form>
    </section>

    </div>

</div>
