<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return view('pages.⚡help.help')
            ->title(__('pages/help.title'));
    }
};
