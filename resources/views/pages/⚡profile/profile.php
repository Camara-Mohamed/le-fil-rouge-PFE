<?php

use App\Livewire\Forms\ProfileForm;
use App\Traits\HandlesAvatar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Mon Profil')] class extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;
    use HandlesAvatar;

    public ProfileForm $form;

    public $avatar;

    public function mount(): void
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $this->form->setProfile($user);
    }

    public function save(): void
    {
        $this->form->update();

        session()->flash('success', 'Le profil est mis à jour.');
    }

    public function render()
    {
        return view('pages.⚡profile.profile');
    }
};
