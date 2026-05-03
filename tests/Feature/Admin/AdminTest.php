<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('verifies if user can access admin dashboard page as a connected', function () {
    actingAs($this->user);

    $response = $this->get(route('admin.dashboard', ['locale' => app()->getLocale()]));

    $response->assertStatus(200);
});
