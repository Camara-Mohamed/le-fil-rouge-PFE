<?php

namespace App\Livewire\Forms;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CommentForm extends Form
{
    #[Validate('required|string|max:2000')]
    public string $content = '';

    #[Validate('nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,webp')]
    public $document = null;

    public function store(Model $model): Comment
    {
        $this->validate();

        $data = [
            'content' => $this->content,
        ];

        if ($this->document) {
            $data['document'] = $this->document->store('comments/documents', config('filesystems.default'));
        }

        $comment = $model->comments()->make($data);
        $comment->user_id = auth()->id();
        $comment->is_admin = auth()->user()->isAdmin();
        $comment->save();

        $this->reset();

        return $comment;
    }
}
