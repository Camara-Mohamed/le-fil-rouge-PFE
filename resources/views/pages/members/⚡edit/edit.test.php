<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::members.edit')
        ->assertStatus(200);
});
