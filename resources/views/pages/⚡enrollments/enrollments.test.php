<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::enrollments')
        ->assertStatus(200);
});
