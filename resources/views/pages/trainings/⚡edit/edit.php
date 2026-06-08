<?php

use App\Enums\UserRoles;
use App\Livewire\Forms\TrainingForm;
use App\Models\Training;
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

    public Training $training;

    public TrainingForm $form;

    public function mount(Training $training): void
    {
        $this->authorize('update', $training);
        $this->training = $training;

        $this->form->fill([
            'title' => $training->title,
            'description' => $training->description,
            'start_date' => $training->start_date?->format('Y-m-d\TH:i'),
            'end_date' => $training->end_date?->format('Y-m-d\TH:i'),
            'type' => $training->type->value,
            'price' => $training->price,
            'participants' => $training->participants,
            'details' => $training->details,
            'constraints' => $training->constraints,
            'address' => $training->address,
            'number' => $training->number,
            'city' => $training->city,
            'province' => $training->province->value,
            'postal_code' => $training->postal_code,
            'roles' => $training->roles ?? [],
            'status' => $training->status->value,
        ]);
    }

    public function save(): void
    {
        $this->authorize('update', $this->training);

        $this->form->update($this->training);

        $admins = User::where('role', UserRoles::ADMIN->value)->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            $admin->notify(new ModelChangedNotification($this->training, 'la formation', auth()->user(), created: false));
        }
        Notification::route('mail', config('mail.reply_to.address'))->notify(new ModelChangedNotification($this->training, 'la formation', auth()->user(), created: false));

        $this->dispatch('toast', message: __('toast/trainings.updated'), type: 'success');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->training);

        $this->training->delete();

        $this->redirectRoute('public.trainings.index', ['locale' => app()->getLocale()]);
    }

    public function deleteGalerie(int $galerieId): void
    {
        $this->authorize('update', $this->training);

        $galerie = $this->training->galeries()->findOrFail($galerieId);

        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();

        $this->training->unsetRelation('galeries');

        $this->dispatch('toast', message: __('toast/trainings.image_deleted'), type: 'success');
    }

    public function openConfirmDeleteModal(): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::trainings.confirm-delete',
            'model_id' => (string) $this->training->id,
            'model_type' => 'training',
        ]);
    }

    public function openConfirmDeleteGalerieModal(int $galerieId): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::trainings.confirm-delete-galerie',
            'model_id' => (string) $galerieId,
            'model_type' => 'galerie',
        ]);
    }

    #[On('galerie_deleted')]
    public function onGalerieDeleted(): void
    {
        $this->training->unsetRelation('galeries');
    }

    public function render()
    {
        return view('pages.trainings.⚡edit.edit')
            ->title($this->training->title);
    }
};
