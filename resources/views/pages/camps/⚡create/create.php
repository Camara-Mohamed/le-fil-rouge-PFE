<?php

use App\Enums\CampTypes;
use App\Enums\UserRoles;
use App\Livewire\Forms\CampForm;
use App\Models\Camp;
use App\Models\User;
use App\Notifications\ModelChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Ajouter un camp')] class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public CampForm $form;

    public function save(): void
    {
        $this->authorize('create', Camp::class);

        $camp = $this->form->store(auth()->user());

        $type = $this->form->type === CampTypes::STAGE->value ? 'stage' : 'camp';

        $admins = User::where('role', UserRoles::ADMIN->value)->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            $admin->notify(new ModelChangedNotification($camp, 'le camp', auth()->user(), created: true));
        }
        Notification::route('mail', config('mail.reply_to.address'))->notify(new ModelChangedNotification($camp, 'le camp', auth()->user(), created: true));

        session()->flash('success', __('toast/camps.created', ['type' => $type]));

        $this->redirectRoute('admin.camps.edit', [
            'locale' => app()->getLocale(),
            'camp' => $camp,
        ]);
    }

    public function render()
    {
        return view('pages.camps.⚡create.create');
    }
};
