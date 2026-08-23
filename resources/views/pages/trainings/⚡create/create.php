<?php

use App\Enums\UserRoles;
use App\Livewire\Forms\TrainingForm;
use App\Models\Training;
use App\Models\User;
use App\Notifications\ModelChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public TrainingForm $form;

    public function save(): void
    {
        $this->authorize('create', Training::class);

        $training = $this->form->store(auth()->user());

        try {
            $admins = User::where('role', UserRoles::ADMIN->value)->where('id', '!=', auth()->id())->get();
            foreach ($admins as $admin) {
                $admin->notify(new ModelChangedNotification($training, 'la formation', auth()->user(), created: true));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new ModelChangedNotification($training, 'la formation', auth()->user(), created: true));
        } catch (\Throwable) {}

        session()->flash('success', __('toast/trainings.created'));

        $this->redirectRoute('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training]);
    }

    public function render()
    {
        return view('pages.trainings.⚡create.create')
            ->title(__('pages/trainings.create_page_title'));
    }
};
