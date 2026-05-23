<?php

use App\Livewire\Forms\TrainingForm;
use App\Models\Training;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
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
            'start_date' => $training->start_date,
            'end_date' => $training->end_date,
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

        session()->flash('success', 'Mise à jour.');
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
    }

    public function render()
    {
        return view('pages.trainings.⚡edit.edit')
            ->title($this->training->title);
    }
};
