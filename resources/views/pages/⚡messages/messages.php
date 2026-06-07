<?php

use App\Enums\VolunteerRequestStatus;
use App\Models\ContactMessage;
use App\Models\VolunteerRequest;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Les messages')] class extends Component
{
    use WithPagination;

    #[Url] public string $tab = 'contact';
    #[Url] public string $search = '';
    #[Url] public string $filterRead = '';
    #[Url] public string $filterStatus = '';

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterRead(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function switchTab(string $tab): void
    {
        $this->tab = $tab;
        $this->reset('search', 'filterRead', 'filterStatus');
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'filterRead', 'filterStatus');
        $this->resetPage();
    }

    public function paginationView(): string { return 'vendor.pagination.tailwind'; }

    public function markAsRead(int $id, string $type): void
    {
        $model = $type === 'contact'
            ? ContactMessage::findOrFail($id)
            : VolunteerRequest::findOrFail($id);

        $model->read_at = now();
        $model->save();
    }

    public function resetToPending(int $id): void
    {
        VolunteerRequest::findOrFail($id)->update(['status' => VolunteerRequestStatus::PENDING]);
        $this->dispatch('toast', message: __('toast/messages.volunteer_reset'));
    }

    public function rejectVolunteer(int $id): void
    {
        VolunteerRequest::findOrFail($id)->update(['status' => VolunteerRequestStatus::REJECTED]);
        $this->dispatch('toast', message: __('toast/messages.volunteer_rejected'), type: 'info');
    }

    public function openCreateMember(int $id): void
    {
        $this->dispatch('open_modal', payload: [
            'form'       => 'modals::create-member',
            'model_id'   => (string) $id,
            'model_type' => 'volunteer_request',
        ]);
    }

    public function openRefuseModal(int $id): void
    {
        $this->dispatch('open_modal', payload: [
            'form'       => 'modals::volunteer.confirm-refuse',
            'model_id'   => (string) $id,
            'model_type' => 'volunteer',
        ]);
    }

    public function openResetPendingModal(int $id): void
    {
        $this->dispatch('open_modal', payload: [
            'form'       => 'modals::volunteer.confirm-reset-pending',
            'model_id'   => (string) $id,
            'model_type' => 'volunteer',
        ]);
    }

    #[On('volunteer_accepted')]
    public function onVolunteerAccepted(): void {}

    #[On('volunteer_rejected')]
    public function onVolunteerRejected(): void {}

    #[On('volunteer_reset')]
    public function onVolunteerReset(): void {}

    public function render()
    {
        $contactsQuery = ContactMessage::latest()
            ->when($this->search, fn ($query) => $query->where(fn ($q) =>
                $q->where('full_name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
            ))
            ->when($this->filterRead === 'read',   fn ($query) => $query->whereNotNull('read_at'))
            ->when($this->filterRead === 'unread', fn ($query) => $query->whereNull('read_at'));

        $volunteersQuery = VolunteerRequest::latest()
            ->when($this->search, fn ($query) => $query->where(fn ($q) =>
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
            ))
            ->when($this->filterRead === 'read',   fn ($query) => $query->whereNotNull('read_at'))
            ->when($this->filterRead === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->when($this->filterStatus, fn ($query) => $query->where('status', $this->filterStatus));

        $contacts   = $this->tab === 'contact'   ? $contactsQuery->paginate(6)   : collect();
        $volunteers = $this->tab === 'volunteer'  ? $volunteersQuery->paginate(6) : collect();

        $unreadContacts   = ContactMessage::whereNull('read_at')->count();
        $unreadVolunteers = VolunteerRequest::whereNull('read_at')->count();

        return view('pages.⚡messages.messages', compact(
            'contacts', 'volunteers', 'unreadContacts', 'unreadVolunteers'
        ));
    }
};
