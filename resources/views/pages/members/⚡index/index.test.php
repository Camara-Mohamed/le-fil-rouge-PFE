<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::members.index')
        ->assertStatus(200);
});
