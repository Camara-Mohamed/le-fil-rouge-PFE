<?php

use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\DietForm;
use App\Livewire\Forms\DocumentForm;
use App\Livewire\Forms\EmailForm;
use App\Livewire\Forms\InfoForm;
use App\Livewire\Forms\PasswordForm;
use App\Traits\HandlesAvatar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests , HandlesAvatar, WithFileUploads;

    public InfoForm $info;

    public EmailForm $email;

    public PasswordForm $password;

    public AddressForm $address;

    public DietForm $diet;

    public DocumentForm $document;

    #[Validate(['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'])]
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
        $this->dispatch('toast', message: __('toast/profile.info_updated'), type: 'success');
    }

    public function saveEmail(): void
    {
        $this->email->update();
        $this->dispatch('toast', message: __('toast/profile.email_updated'), type: 'success');
    }

    public function savePassword(): void
    {
        $this->password->update();
        $this->dispatch('toast', message: __('toast/profile.password_updated'), type: 'success');
    }

    public function saveAddress(): void
    {
        $this->address->update();
        $this->dispatch('toast', message: __('toast/profile.address_updated'), type: 'success');
    }

    public function saveDiet(): void
    {
        $this->diet->update();
        $this->dispatch('toast', message: __('toast/profile.diet_updated'), type: 'success');
    }

    public function uploadDocument(): void
    {
        $this->document->upload();
        $this->dispatch('toast', message: __('toast/profile.doc_added'), type: 'success');
    }

    public function openConfirmDeleteDocumentModal(int $id): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::documents.confirm-delete',
            'model_id' => (string) $id,
            'model_type' => 'document',
        ]);
    }

    #[On('document_deleted')]
    public function onDocumentDeleted(): void {}

    public function render()
    {
        return view('pages.⚡profile.profile', [
            'documents' => auth()->user()->documents()->get(),
        ])->title(__('navigation.profile'));
    }
};
