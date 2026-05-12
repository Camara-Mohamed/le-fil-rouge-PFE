<?php

namespace App\Livewire\Forms;

use App\Models\Announcement;
use App\Models\User;
use Livewire\Form;
use Livewire\WithFileUploads;

class AnnouncementForm extends Form
{
    use WithFileUploads;

    public string  $title       = '';
    public string  $description = '';
    public string  $content     = '';
    public ?string $details     = null;
    public ?string $published_at = null;
    public $banner = null;

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:255'],
            'content'      => ['required', 'string'],
            'details'      => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'banner'       => ['nullable', 'image'],
        ];
    }

    public function store(User $user): Announcement
    {
        $this->validate();

        $data = [
            'title'        => $this->title,
            'description'  => $this->description,
            'content'      => $this->content,
            'details'      => $this->details,
            'published_at' => $this->published_at ?: null,
            'user_id'      => $user->id,
        ];

        if ($this->banner) {
            $data['banner'] = $this->banner->store('announcements', 'public');
        }

        return Announcement::create($data);
    }

    public function update(Announcement $announcement): void
    {
        $this->validate();

        $data = [
            'title'        => $this->title,
            'description'  => $this->description,
            'content'      => $this->content,
            'details'      => $this->details,
            'published_at' => $this->published_at ?: null,
        ];

        if ($this->banner) {
            $data['banner'] = $this->banner->store('announcements', 'public');
        }

        $announcement->update($data);
    }
}
