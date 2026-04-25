<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\get;

it('does see the logout button as a guest', function () {
    // Act
    $response = get(route('dashboard'));

    // Assert
    $response->assertSee('Logout');
});

it('can logout a user', function () {
    // Arrange
    $user = User::factory()->create();

    $this->actingAs($user);

    // Act
    $response = $this->post(route('logout'));

    // Assert
    $response->assertRedirect('/home');
    expect(Auth::check())->toBeFalse();
});
