<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::camps.edit')
        ->assertStatus(200);
});
