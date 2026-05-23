<?php

use App\Livewire\Forms\CampForm;
use App\Models\Camp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
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
            'start_date' => $camp->start_date,
            'end_date' => $camp->end_date,
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

        session()->flash('success', 'Mis à jour');
    }

    public function deleteGalerie(int $galerieId): void
    {
        $this->authorize('update', $this->camp);

        $galerie = $this->camp->galeries()->findOrFail($galerieId);

        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->camp);

        $this->camp->delete();

        $this->redirectRoute('public.camps.index', ['locale' => app()->getLocale()]);
    }

    public function render()
    {
        return view('pages.camps.⚡edit.edit')
            ->title($this->camp->title);
    }
};
