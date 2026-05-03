<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('does see the logout button as a connected', function () {
    // Arrange
    actingAs($this->user);

    // Act
    $response = get(route('admin.dashboard', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertSee('Logout');
});

it('does not show logout button as a guest', function () {
    // Act
    $response = get(route('public.home', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertDontSee('Logout');
});
