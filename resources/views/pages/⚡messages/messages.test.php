<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::messages')
        ->assertStatus(200);
});
