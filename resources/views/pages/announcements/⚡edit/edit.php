<?php

use App\Livewire\Forms\AnnouncementForm;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Announcement $announcement;

    public AnnouncementForm $form;

    public function mount(Announcement $announcement): void
    {
        $this->authorize('update', $announcement);
        $this->announcement = $announcement;
        $this->form->fill($announcement);
    }

    public function save(): void
    {
        $this->authorize('update', $this->announcement);

        $this->form->update($this->announcement);

        session()->flash('success', 'Mise à jour.');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->announcement);

        $this->announcement->delete();

        $this->redirectRoute('public.announcements.index', ['locale' => app()->getLocale()]);
    }

    public function render()
    {
        return view('pages.announcements.⚡edit.edit')
            ->title($this->announcement->title);
    }
};
