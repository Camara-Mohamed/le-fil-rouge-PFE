<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::help')
        ->assertStatus(200);
});
