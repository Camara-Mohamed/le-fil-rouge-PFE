<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('verifies if user can access admin dashboard page as a connected', function () {
    actingAs($this->user);

    $response = get(route('admin.dashboard'));

    $response->assertStatus(200);
});
