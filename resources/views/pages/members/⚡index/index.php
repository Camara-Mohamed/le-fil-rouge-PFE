<?php

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Les membres')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $role = '';

    public string $status = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRole(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->where('id', '!=', auth()->id());

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('first_name', 'like', "%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('pages.members.⚡index.index', ['members' => $query->paginate(10)]);
    }
};
