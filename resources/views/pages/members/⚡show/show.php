<?php

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public User $member;

    public function delete(): void
    {
        $this->authorize('delete', $this->member);

        $this->member->delete();

        $this->redirectRoute('admin.members.index', [
            'locale' => app()->getLocale(),
        ]);
    }

    public function render()
    {
        return view('pages.members.⚡show.show')
            ->title($this->member->fullName());
    }
};
