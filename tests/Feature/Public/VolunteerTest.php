<?php

use App\Models\VolunteerRequest;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\post;

it('guest can submit volunteer form', function () {
    Mail::fake();

    $response = post(route('public.volunteer.store', ['locale' => 'fr']), [
        'first_name' => 'Jean',
        'last_name'  => 'Dupont',
        'email'      => 'jean.dupont@gmail.com',
        'phone'      => '+32 470 00 00 00',
        'message'    => 'Je veux devenir volontaire.',
    ]);

    $response->assertRedirect();
    expect(VolunteerRequest::where('email', 'jean.dupont@gmail.com')->exists())->toBeTrue();
});

it('volunteer form fails validation with missing fields', function () {
    post(route('public.volunteer.store', ['locale' => 'fr']), [])
        ->assertSessionHasErrors(['first_name', 'last_name', 'email']);
});
