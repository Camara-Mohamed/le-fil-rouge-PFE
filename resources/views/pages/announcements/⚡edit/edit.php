<?php

use App\Livewire\Forms\AnnouncementForm;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

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
            'banner' => $this->announcement->title,
            'published_at' => $announcement->published_at?->format('Y-m-d\TH:i'),
        ]);
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

    public function deleteGalerie(int $galerieId): void
    {
        $this->authorize('update', $this->announcement);

        $galerie = $this->announcement->galeries()->findOrFail($galerieId);

        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();
    }

    public function render()
    {
        return view('pages.announcements.⚡edit.edit')
            ->title($this->announcement->title);
    }
};
