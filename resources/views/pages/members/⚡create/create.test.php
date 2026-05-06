<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::members.create')
        ->assertStatus(200);
});
