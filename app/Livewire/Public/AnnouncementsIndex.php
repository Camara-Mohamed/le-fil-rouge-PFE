<?php

namespace App\Livewire\Public;

use App\Models\Announcement;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementsIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: 'desc')]
    public string $sort = 'desc';

    public function mount(): void
    {
        $request = request();

        $this->search = $request->string('q')->trim()->toString();
        $this->sort = in_array($request->input('sort'), ['asc', 'desc'])
            ? $request->input('sort')
            : 'desc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function filter(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->sort = 'desc';
        $this->resetPage();
    }

    public function paginationView(): string
    {
        return 'vendor.pagination.tailwind';
    }

    public function render()
    {
        $user = auth()->user();

        if ($user?->isAdmin()) {
            $query = Announcement::query();
        } else {
            $query = Announcement::query()->whereNotNull('published_at');
        }

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $query->where(fn ($q) => $q->where('title', 'like', $s)->orWhere('description', 'like', $s));
        }

        return view('livewire.public.announcements-index', [
            'announcements' => $query->orderBy('published_at', $this->sort)->paginate(9)->withQueryString()->setPath(route('public.announcements.index', ['locale' => app()->getLocale()])),
        ]);
    }
}
