<?php

namespace App\Livewire\Forms;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CommentForm extends Form
{
    #[Validate('required|string')]
    public string $content = '';

    #[Validate('nullable|file|max:10240')]
    public $document = null;

    public function store(Model $model): Comment
    {
        $this->validate();

        $data = [
            'content' => $this->content,
            'user_id' => auth()->id(),
            'is_admin' => auth()->user()->isAdmin(),
        ];

        if ($this->document) {
            $data['document'] = $this->document->store('comments/documents', 'public');
        }

        $comment = $model->comments()->create($data);

        $this->reset();

        return $comment;
    }
}
