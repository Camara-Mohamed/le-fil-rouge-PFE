<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::trainings.edit')
        ->assertStatus(200);
});
