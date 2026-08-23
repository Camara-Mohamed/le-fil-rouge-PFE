<?php

use App\Models\CampRegister;
use App\Models\TrainingRegister;
use Livewire\Component;

new class extends Component
{
    public function mount(): void
    {
        if (auth()->user()->isAdmin()) {
            $this->redirectRoute('admin.dashboard', ['locale' => app()->getLocale()]);
        }
    }

    public function render()
    {
        $trainingRegisters = TrainingRegister::with('training')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $campRegisters = CampRegister::with('camp')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.⚡enrollments.enrollments', compact('trainingRegisters', 'campRegisters'))
            ->title(__('navigation.history'));
    }
};
