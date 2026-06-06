@php
    use App\Enums\UserRoles;

    $user    = auth()->user();
    $info  = 'pages/help.' . $user->role->value;
    $links = [
        'admin'        => '',
        'formateur'    => '',
        'coordinateur' => '',
        'animateur'    => '',
        'arrivant'     => '',
    ];

    $src = match($user->role) {
        UserRoles::ADMIN                             => $links['admin'],
        UserRoles::FORMATEUR                         => $links['formateur'],
        UserRoles::COORDINATEUR                      => $links['coordinateur'],
        UserRoles::ANIMATEUR_1, UserRoles::ANIMATEUR_2,
        UserRoles::BREVETE                           => $links['animateur'],
        UserRoles::ARRIVANT                          => $links['arrivant'],
    };
@endphp

<div class="flex flex-col gap-8 max-w-3xl mx-auto py-12 px-4">

    {{-- Genially --}}
    <div class="w-full aspect-video bg-danger-bg rounded-2xl overflow-hidden">
        <iframe
            src="{{ $src }}"
            allowfullscreen
            allow="autoplay; fullscreen"
            class="w-full h-full border-0"
            title="{{ __('pages/help.title') }}"
        ></iframe>
    </div>

    {{-- Message --}}
    <div class="px-6 py-4 bg-white rounded-tl-sm rounded-bl-sm shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] border-l-[6px] border-red flex flex-col gap-2">
        <p class="font-sans font-black text-base text-dark">{{ __('pages/help.title') }}</p>
        <p class="font-serif font-medium text-base text-dark">{{ __($info) }}</p>
    </div>

</div>
