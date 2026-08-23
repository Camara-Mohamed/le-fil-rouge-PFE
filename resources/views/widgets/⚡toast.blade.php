<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array $toasts = [];

    #[On('toast')]
    public function add(string $message, string $type = 'success'): void
    {
        $this->toasts[] = [
            'id'      => uniqid(),
            'message' => $message,
            'type'    => $type,
        ];
    }

    public function remove(string $id): void
    {
        $this->toasts = array_values(array_filter($this->toasts, fn ($t) => $t['id'] !== $id));
    }
};
?>

<div class="fixed top-6 right-4 z-[120] flex flex-col gap-3 w-80">
    @foreach ($toasts as $toast)
        <div
            wire:key="{{ $toast['id'] }}"
            x-data
            x-init="setTimeout(() => $wire.remove('{{ $toast['id'] }}'), 4000)"
            role="{{ in_array($toast['type'], ['error', 'danger']) ? 'alert' : 'status' }}"
            aria-live="{{ in_array($toast['type'], ['error', 'danger']) ? 'assertive' : 'polite' }}"
            @class([
                'p-4 rounded-2xl border-l-4 flex items-center justify-between gap-3 shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)]',
                'bg-success-bg border-success text-success' => $toast['type'] === 'success',
                'bg-warning-bg border-warning text-warning' => $toast['type'] === 'warning',
                'bg-danger-bg  border-danger  text-danger'  => in_array($toast['type'], ['error', 'danger']),
                'bg-info-bg    border-info    text-info'    => $toast['type'] === 'info',
            ])
        >
            <p class="font-sans text-sm font-medium">{{ $toast['message'] }}</p>

            <button type="button" wire:click="remove('{{ $toast['id'] }}')" aria-label="{{ __('general.close') }}" class="shrink-0 hover:opacity-70 transition duration-200">
                <x-icons.close class="size-4" fill="fill-current" />
            </button>
        </div>
    @endforeach
</div>
