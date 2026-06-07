<?php

namespace App\Livewire\Forms;

use App\Enums\DocumentTypes;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class DocumentForm extends Form
{
    use WithFileUploads;

    public User $user;

    #[Validate('required|file|max:10240')]
    public $file = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate(['nullable', new EnumRule(DocumentTypes::class)])]
    public string $type = DocumentTypes::AUTRE->value;

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

    public function delete(Document $document): void
    {
        Gate::authorize('delete', $document);
        Storage::disk('public')->delete($document->path);
        $document->delete();
    }
}
