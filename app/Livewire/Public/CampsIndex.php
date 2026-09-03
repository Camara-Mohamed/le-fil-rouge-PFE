<?php

namespace App\Livewire\Public;

use App\Enums\CampStatus;
use App\Models\Camp;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CampsIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $type = '';

    #[Url(except: '')]
    public string $province = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: 'desc')]
    public string $sort = 'desc';

    public function mount(): void
    {
        $request = request();

        $this->search = $request->string('q')->trim()->toString();
        $this->type = $request->string('type')->toString();
        $this->province = $request->string('province')->toString();
        $this->status = $request->string('status')->toString();
        $this->sort = in_array($request->input('sort'), ['asc', 'desc'])
            ? $request->input('sort')
            : 'desc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function updatingProvince(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
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
        $this->type = '';
        $this->province = '';
        $this->status = '';
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
            $query = Camp::query()->with(['user', 'acceptedRegisters']);
        } elseif ($user) {
            $query = Camp::query()
                ->with(['user', 'acceptedRegisters'])
                ->where(function ($q) use ($user) {
                    $q->where('status', CampStatus::PUBLISHED)
                        ->orWhere('user_id', $user->id)
                        ->orWhereHas('registers', fn ($r) => $r->where('user_id', $user->id));
                });
        } else {
            $query = Camp::query()
                ->with(['user', 'acceptedRegisters'])
                ->where('status', CampStatus::PUBLISHED);
        }

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $query->where(fn ($q) => $q->where('title', 'like', $s)->orWhere('description', 'like', $s));
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }
        if ($this->province) {
            $query->where('province', $this->province);
        }
        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.public.camps-index', [
            'camps' => $query->orderBy('start_date', $this->sort)->paginate(6)->withQueryString()->setPath(route('public.camps.index', ['locale' => app()->getLocale()])),
        ]);
    }
}
