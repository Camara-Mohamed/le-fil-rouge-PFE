<?php

use App\Enums\UserRoles;
use App\Livewire\Forms\TrainingForm;
use App\Models\Training;
use App\Models\User;
use App\Notifications\ModelChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Ajouter une formation')] class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public TrainingForm $form;

    public function save(): void
    {
        $this->authorize('create', Training::class);

        $training = $this->form->store(auth()->user());

        $admins = User::where('role', UserRoles::ADMIN->value)->where('id', '!=', auth()->id())->get();
        Notification::send($admins, new ModelChangedNotification($training, 'la formation', auth()->user(), created: true));

        session()->flash('success', __('toast/trainings.created'));

        $this->redirectRoute('admin.trainings.edit', ['locale' => app()->getLocale(), 'training' => $training]);
    }

    public function render()
    {
        return view('pages.trainings.⚡create.create');
    }
};
