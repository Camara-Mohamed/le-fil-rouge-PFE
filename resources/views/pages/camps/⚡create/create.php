<?php

use App\Enums\CampTypes;
use App\Livewire\Forms\CampForm;
use App\Models\Camp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
