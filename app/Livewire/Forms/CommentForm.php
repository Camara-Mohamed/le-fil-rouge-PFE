<?php

namespace App\Livewire\Forms;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Form;

class CommentForm extends Form
{
    public string $content = '';
    public $document = null;

    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'document' => ['nullable', 'file', 'max:10240'],
        ];
    }

    public function store(Model $model): Comment
    {
        $this->validate();

        $data = [
            'content'  => $this->content,
            'user_id'  => auth()->id(),
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
