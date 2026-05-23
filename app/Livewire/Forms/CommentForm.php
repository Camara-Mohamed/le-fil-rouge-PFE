<?php

namespace App\Livewire\Forms;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Form;

class CommentForm extends Form
{
    public string $content = '';

    public function rules(): array
    {
        return [
            'content' => ['string'],
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

        $comment = Comment::create($data);

        $this->reset();

        return $comment;
    }
}
