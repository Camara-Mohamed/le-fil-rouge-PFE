<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::trainings.create')
        ->assertStatus(200);
});
