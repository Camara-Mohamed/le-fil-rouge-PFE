<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('does see the logout button as a connected', function () {
    // Arrange
    actingAs($this->user);

    // Act
    $response = get(route('dashboard'));

    // Assert
    $response->assertSee('Logout');
});

it('can logout a user', function () {
    // Arrange
    actingAs($this->user);

    // Act
    $response = $this->post(route('logout'));

    // Assert
    $response->assertRedirect(route('home'));
    expect(Auth::check())->toBeFalse();
});

it('does not show logout button as a guest', function () {
    // Act
    $response = get(route('home'));

    // Assert
    $response->assertDontSee('Logout');
});
