<?php

use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\DietForm;
use App\Livewire\Forms\DocumentForm;
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

    public InfoForm $info;

    public EmailForm $email;

    public PasswordForm $password;

    public AddressForm $address;

    public DietForm $diet;

    public DocumentForm $document;

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
        $this->document->setUser($user);
    }

    public function saveInfo(): void
    {
        $this->info->update();
        session()->flash('success', 'Info mis à jour');
    }

    public function saveEmail(): void
    {
        $this->email->update();
        session()->flash('success', 'Mail mis à jour');
    }

    public function savePassword(): void
    {
        $this->password->update();
        session()->flash('success', 'Mdp mis à jour');
    }

    public function saveAddress(): void
    {
        $this->address->update();
        session()->flash('success', 'Adresse mis à jour');
    }

    public function saveDiet(): void
    {
        $this->diet->update();
        session()->flash('success', 'Regime mis à jour');
    }

    public function uploadDocument(): void
    {
        $this->document->upload();
        session()->flash('success', 'Document ajouté.');

        // Notification
    }

    public function deleteDocument(int $id): void
    {
        $this->document->delete($id);
        session()->flash('success', 'Document supprimé.');

        // Notification
    }

    public function render()
    {
        return view('pages.⚡profile.profile', [
            'documents' => auth()->user()->documents()->get(),
        ]);
    }
};
