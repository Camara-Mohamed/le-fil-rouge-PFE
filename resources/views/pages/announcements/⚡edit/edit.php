<?php

use App\Livewire\Forms\AnnouncementForm;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use AuthorizesRequests, WithFileUploads;

    public Announcement $announcement;

    public AnnouncementForm $form;

    public function mount(Announcement $announcement): void
    {
        $this->authorize('update', $announcement);
        $this->announcement = $announcement;

        $this->form->fill([
            'title' => $this->announcement->title,
            'description' => $this->announcement->description,
            'details' => $this->announcement->details,
            'content' => $this->announcement->content,
            'published_at' => $announcement->published_at?->format('Y-m-d\TH:i'),
        ]);
    }

    public function save(): void
    {
        $this->authorize('update', $this->announcement);

        $this->form->update($this->announcement);

        $this->dispatch('toast', message: __('toast/announcements.updated'), type: 'success');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->announcement);

        $this->announcement->delete();

        session()->flash('success', __('toast/announcements.deleted'));

        $this->redirectRoute('public.announcements.index', ['locale' => app()->getLocale()]);
    }

    public function deleteGalerie(int $galerieId): void
    {
        $this->authorize('update', $this->announcement);

        $galerie = $this->announcement->galeries()->findOrFail($galerieId);

        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();

        $this->announcement->unsetRelation('galeries');

        $this->dispatch('toast', message: __('toast/announcements.image_deleted'), type: 'success');
    }

    public function openConfirmDeleteModal(): void
    {
        $this->dispatch('open_modal', payload: [
            'form'       => 'modals::announcements.confirm-delete',
            'model_id'   => (string) $this->announcement->id,
            'model_type' => 'announcement',
        ]);
    }

    public function openConfirmDeleteGalerieModal(int $galerieId): void
    {
        $this->dispatch('open_modal', payload: [
            'form'       => 'modals::announcements.confirm-delete-galerie',
            'model_id'   => (string) $galerieId,
            'model_type' => 'galerie',
        ]);
    }

    #[On('galerie_deleted')]
    public function onGalerieDeleted(): void
    {
        $this->announcement->unsetRelation('galeries');
    }

    public function render()
    {
        return view('pages.announcements.⚡edit.edit')
            ->title($this->announcement->title);
    }
};
