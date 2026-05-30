@php
    use Illuminate\Support\Facades\Storage;

    $initials = strtoupper($member->first_name[0] . $member->last_name[0]);
    $sizes    = config('avatar.sizes');
@endphp

<div class="flex flex-col gap-8">

    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
        ['label' => $member->fullName()],
    ]" />
    <a href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}">Retour</a>

    <div class="flex gap-6">
        @if($member->avatar_path)
            <a href="{{ asset('storage/avatars/originals/' . $member->avatar_path) }}" data-fancybox="avatar">
                <img
                    src="{{ asset('storage/avatars/originals/' . $member->avatar_path) }}"
                    srcset="
                    @foreach($sizes as $size)
                        {{ asset('storage/' . sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']) . '/' . $member->avatar_path) }} {{ $size['width'] }}w,
                    @endforeach
                    "
                    class="w-24 h-24 rounded-full"
                >
            </a>
        @else
            <div class="w-24 h-24 rounded-full flex items-center justify-center border">
                {{ $initials }}
            </div>
        @endif

        <div>
            <h2>{{ $member->fullName() }}</h2>
            <p>{{ $member->role->label() }}</p>
        </div>
    </div>

    <section>
        <h3>Informations personnelles</h3>
        <div>
            <p><span>Email :</span> {{ $member->email }}</p>
            @if($member->phone)
                <p><span>Téléphone :</span> {{ $member->phone }}</p>
            @endif
            @if($member->birth_date)
                <p><span>Date de naissance :</span> {{ $member->birth_date->format('d/m/Y') }}
                    ({{ $member->getAge() }} ans)</p>
            @endif
        </div>
    </section>

    @if($member->address || $member->city)
        <section>
            <h3>Adresse</h3>
            <div>
                @if($member->address)
                    <p><span>Rue :</span> {{ $member->address }} {{ $member->number }}</p>
                @endif
                @if($member->city)
                    <p><span>Ville :</span> {{ $member->city }} {{ $member->postal_code }}</p>
                @endif
                @if($member->province)
                    <p><span>Province :</span> {{ $member->province->label() }}</p>
                @endif
            </div>
        </section>
    @endif

    @if($member->diet)
        <section>
            <h3>Régime alimentaire</h3>
            <ul>
                <li><span>Régime :</span> {{ $member->diet->label() }}</li>
                @if($member->allergies)
                    <li><span>Allergies :</span> {{ $member->allergies }}</li>
                @endif
            </ul>
        </section>
    @endif

    <section>
        <h3>Documents</h3>
        @if($member->documents)
            @foreach($member->documents as $document)
                <div>
                    <span>{{ $document->name }}</span>
                    <span>{{ $document->type }}</span>
                    <a
                        href="{{ Storage::disk('public')->url($document->path) }}"
                        data-fancybox="member-document"
                        data-type="iframe"
                        data-width="1000"
                        data-height="900"
                    >Voir</a>
                </div>
            @endforeach
        @else
            <p>Aucun document</p>
        @endif
    </section>

    <section>
        <h3>Formations</h3>
        @forelse($trainingRegisters as $register)
            <div wire:key="training-register-{{ $register->id }}">
                <p>{{ $register->training->title }}</p>
                <p>{{ $register->training->start_date->format('d/m/Y') }}</p>
                <p>{{ $register->status->label() }}</p>
            </div>
        @empty
            <p>Aucune formation</p>
        @endforelse
    </section>

    <section>
        <h3>Camps</h3>
        @forelse($campRegisters as $register)
            <div wire:key="camp-register-{{ $register->id }}">
                <p>{{ $register->camp->title }}</p>
                <p>{{ $register->camp->start_date->format('d/m/Y') }}</p>
                <p>{{ $register->status->label() }}</p>
            </div>
        @empty
            <p>Aucun camp</p>
        @endforelse
    </section>

    <div>
        <a href="{{ route('admin.members.edit', ['locale' => app()->getLocale(), 'member' => $member]) }}">Modifier</a>

        @can('delete', $member)
            <button type="button" wire:click="openConfirmDeleteModal">Archiver</button>
        @endcan

        @can('forceDelete', $member)
            <button type="button" wire:click="openConfirmForceDeleteModal">Supprimer définitivement</button>
        @endcan
    </div>

</div>
