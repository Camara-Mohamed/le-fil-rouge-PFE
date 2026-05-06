<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::members.show')
        ->assertStatus(200);
});
