<?php

use App\Models\CampRegister;
use App\Models\TrainingRegister;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Mon historique')] class extends Component
{
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

        return view('pages.⚡enrollments.enrollments', compact('trainingRegisters', 'campRegisters'));
    }
};
