<?php

use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\DietForm;
use App\Livewire\Forms\EmailForm;
use App\Livewire\Forms\InfoForm;
use App\Livewire\Forms\PasswordForm;
use App\Traits\HandlesAvatar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Mon Profil')] class extends Component
{
    use AuthorizesRequests;
    use HandlesAvatar;
    use WithFileUploads;

    public InfoForm     $info;
    public EmailForm    $email;
    public PasswordForm $password;
    public AddressForm  $address;
    public DietForm     $diet;

    public $avatar;

    public function mount(): void
    {
        $user = auth()->user();

        $this->authorize('update-profile', $user);

        $this->info->setUser($user);
        $this->email->setUser($user);
        $this->password->setUser($user);
        $this->address->setUser($user);
        $this->diet->setUser($user);
    }

    public function saveInfo(): void
    {
        $this->info->update();
    }

    public function saveEmail(): void
    {
        $this->email->update();
    }

    public function savePassword(): void
    {
        $this->password->update();
    }

    public function saveAddress(): void
    {
        $this->address->update();
    }

    public function saveDiet(): void
    {
        $this->diet->update();
    }




    public function render()
    {
        return view('pages.⚡profile.profile', [
            'documents' => auth()->user()->documents()->latest()->get(),
        ]);
    }
};
