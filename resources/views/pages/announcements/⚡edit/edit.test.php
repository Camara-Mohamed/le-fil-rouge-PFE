<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::announcements.edit')
        ->assertStatus(200);
});
