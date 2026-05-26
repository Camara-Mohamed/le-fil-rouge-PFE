<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array $toasts = [];

    #[On('toast')]
    public function add(string $message, string $type = 'success'): void
    {
        $this->toasts[] = [
            'id' => uniqid(),
            'message' => $message,
            'type' => $type,
        ];
    }

    public function remove(string $id): void
    {
        $this->toasts = array_filter($this->toasts, fn ($toast) => $toast['id'] !== $id);
    }
};
?>

<div class="fixed top-6 right-4 z-50 flex flex-col gap-2">
    @foreach ($toasts as $toast)
        <div
            wire:key="{{ $toast['id'] }}"
            x-data
            x-init="setTimeout(() => $wire.remove('{{ $toast['id'] }}'), 3500)"
            class="flex items-center justify-between gap-4 px-4 py-2 bg-dark text-white"
        >
            <span>{{ $toast['message'] }}</span>

            <button
                class="text-white hover:underline"
                wire:click="remove('{{ $toast['id'] }}')"
            >
                Supprimer
            </button>
        </div>
    @endforeach
</div>
