<?php

use App\Enums\UserRoles;
use App\Livewire\Forms\CampForm;
use App\Models\Camp;
use App\Models\User;
use App\Notifications\ModelChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Camp $camp;

    public CampForm $form;

    public function mount(Camp $camp): void
    {
        $this->authorize('update', $camp);
        $this->camp = $camp;

        $this->form->fill([
            'title' => $camp->title,
            'description' => $camp->description,
            'start_date' => $camp->start_date?->format('Y-m-d\TH:i'),
            'end_date' => $camp->end_date?->format('Y-m-d\TH:i'),
            'type' => $camp->type->value,
            'participants' => $camp->participants,
            'details' => $camp->details,
            'constraints' => $camp->constraints,
            'address' => $camp->address,
            'number' => $camp->number,
            'city' => $camp->city,
            'province' => $camp->province->value,
            'postal_code' => $camp->postal_code,
            'roles' => $camp->roles ?? [],
            'status' => $camp->status->value,
        ]);
    }

    public function save(): void
    {
        $this->authorize('update', $this->camp);

        $this->form->update($this->camp);

        try {
            $admins = User::where('role', UserRoles::ADMIN->value)->where('id', '!=', auth()->id())->get();
            foreach ($admins as $admin) {
                $admin->notify(new ModelChangedNotification($this->camp, 'le camp', auth()->user(), created: false));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new ModelChangedNotification($this->camp, 'le camp', auth()->user(), created: false));
        } catch (\Throwable) {}

        $this->dispatch('toast', message: __('toast/camps.updated', ['type' => $this->camp->type->label()]), type: 'success');
    }

    public function deleteGalerie(int $galerieId): void
    {
        $this->authorize('update', $this->camp);

        $galerie = $this->camp->galeries()->findOrFail($galerieId);

        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();

        $this->camp->unsetRelation('galeries');

        $this->dispatch('toast', message: __('toast/camps.image_deleted'), type: 'success');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->camp);

        $this->camp->delete();

        $this->redirectRoute('public.camps.index', ['locale' => app()->getLocale()]);
    }

    public function openConfirmDeleteModal(): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::camps.confirm-delete',
            'model_id' => (string) $this->camp->id,
            'model_type' => 'camp',
        ]);
    }

    public function openConfirmDeleteGalerieModal(int $galerieId): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::camps.confirm-delete-galerie',
            'model_id' => (string) $galerieId,
            'model_type' => 'galerie',
        ]);
    }

    #[On('galerie_deleted')]
    public function onGalerieDeleted(): void
    {
        $this->camp->unsetRelation('galeries');
    }

    public function render()
    {
        return view('pages.camps.⚡edit.edit')
            ->title($this->camp->title);
    }
};
