<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

use function Pest\Laravel\post;

beforeEach(function () {
    $this->user = User::factory()->create();
});

/* it('sends reset password email', function () {
    // Arrange
    Notification::fake();

    // Act
    post(route('password.email'), [
        'email' => $this->user->email,
    ]);

    // Assert
    Notification::assertSentTo($this->user, ResetPassword::class);
}); */

it('resets password', function () {
    // Arrange
    $token = Password::createToken($this->user);

    // Act
    post(route('password.update'), [
        'email' => $this->user->email,
        'password' => 'Change_this',
        'password_confirmation' => 'Change_this',
        'token' => $token,
    ]);

    // Assert
    expect(Hash::check('Change_this', $this->user->fresh()->password))->toBeTrue();
});
