<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::profile')
        ->assertStatus(200);
});
