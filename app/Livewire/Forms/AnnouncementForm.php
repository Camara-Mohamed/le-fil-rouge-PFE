<?php

namespace App\Livewire\Forms;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class AnnouncementForm extends Form
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $description = '';

    #[Validate('required|string')]
    public string $content = '';

    #[Validate('nullable|string')]
    public ?string $details = null;

    #[Validate('nullable|date')]
    public ?string $published_at = null;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048')]
    public $banner = null;

    #[Validate(['galeries' => 'nullable|array', 'galeries.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'])]
    public array $galeries = [];

    public function store(User $user): Announcement
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'details' => $this->details,
            'published_at' => now(),
            'user_id' => $user->id,
        ];

        if ($this->banner) {
            $data['banner'] = $this->banner->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);

        if ($this->galeries) {
            foreach ($this->galeries as $galery) {
                $announcement->galeries()->create([
                    'path' => $galery->store('announcements/galeries', 'public'),
                ]);
            }
        }

        return $announcement;
    }

    public function update(Announcement $announcement): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'details' => $this->details,
            'published_at' => $this->published_at ?? now(),
        ];

        if ($this->banner) {
            if ($announcement->banner) {
                Storage::disk('public')->delete($announcement->banner);
            }
            $data['banner'] = $this->banner->store('announcements/banners', 'public');
        }

        foreach ($this->galeries as $galery) {
            $announcement->galeries()->create([
                'path' => $galery->store('announcements/galeries', 'public'),
            ]);
        }

        $announcement->update($data);

        $this->banner = null;
        $this->galeries = [];
    }
}
