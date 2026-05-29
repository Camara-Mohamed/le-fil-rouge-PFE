<?php

use App\Enums\VolunteerRequestStatus;
use App\Models\ContactMessage;
use App\Models\VolunteerRequest;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Les messages')] class extends Component
{
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
        VolunteerRequest::findOrFail($id)->update([
            'status' => VolunteerRequestStatus::PENDING,
        ]);
        $this->dispatch('toast', message: __('toast/messages.volunteer_reset'));
    }

    public function rejectVolunteer(int $id): void
    {
        $request = VolunteerRequest::findOrFail($id);
        $request->status = VolunteerRequestStatus::REJECTED;
        $request->save();
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
        $contacts = ContactMessage::latest()->get()->map(fn($contact) => (object) [
            'type'       => 'contact',
            'id'         => $contact->id,
            'name'       => $contact->full_name,
            'email'      => $contact->email,
            'subject'    => $contact->sujet,
            'message'    => $contact->message,
            'read_at'    => $contact->read_at,
            'status'     => null,
            'created_at' => $contact->created_at,
        ]);

        $volunteers = VolunteerRequest::latest()->get()->map(fn($volunteer) => (object) [
            'type'       => 'volunteer',
            'id'         => $volunteer->id,
            'name'       => $volunteer->fullName(),
            'email'      => $volunteer->email,
            'subject'    => null,
            'message'    => $volunteer->message,
            'read_at'    => $volunteer->read_at,
            'status'     => $volunteer->status,
            'created_at' => $volunteer->created_at,
        ]);

        $messages = $contacts->merge($volunteers)->sortByDesc('created_at')->values();

        return view('pages.⚡messages.messages', compact('messages'));
    }
};
