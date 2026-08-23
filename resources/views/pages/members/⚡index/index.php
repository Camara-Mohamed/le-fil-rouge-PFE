<?php

use App\Enums\UserStatus;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $role = '';

    #[Url]
    public string $status = '';

    #[Url]
    public bool $archived = false;

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

    public function updatingArchived(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'role', 'status');
        $this->resetPage();
    }

    public function openDeleteModal(int $id): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::members.confirm-delete',
            'model_id' => (string) $id,
            'model_type' => 'member',
        ]);
    }

    public function render()
    {
        $query = User::query()->where('id', '!=', auth()->id());

        if ($this->archived) {
            $query->where('status', UserStatus::ARCHIVED);
        } else {
            $query->where('status', '!=', UserStatus::ARCHIVED);
        }

        if ($this->search) {
            $query->where(fn ($q) => $q->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            );
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $members = $query->paginate(15);

        return view('pages.members.⚡index.index', compact('members'))
            ->title(__('navigation.members'));
    }
};
