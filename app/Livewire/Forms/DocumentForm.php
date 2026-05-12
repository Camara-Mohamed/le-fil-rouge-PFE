<?php

namespace App\Livewire\Forms;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\WithFileUploads;

class DocumentForm extends Form
{
    use WithFileUploads;

    public User $user;

    public $file = null;
    public string $name = '';
    public string $type = '';

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:5120'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function upload(): void
    {
        $this->validate();

        $path = $this->file->store("documents/{$this->user->id}", 'public');

        $this->user->documents()->create([
            'name' => $this->name,
            'type' => $this->type,
            'path' => $path,
        ]);

        $this->reset('file', 'name', 'type');
    }

    public function delete(int $id): void
    {
        $document = Document::findOrFail($id);
        Storage::disk('public')->delete($document->path);
        $document->delete();
    }
}
