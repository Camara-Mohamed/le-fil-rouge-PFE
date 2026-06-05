<?php

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\post;

it('guest can submit the contact form', function () {
    Mail::fake();

    $response = post(route('public.contact.store', ['locale' => 'fr']), [
        'full_name' => 'Jean Dupont',
        'email' => 'jean.dupont@gmail.com',
        'sujet' => 'Message',
        'message' => 'Bonjour !',
    ]);

    $response->assertRedirect();
    expect(ContactMessage::where('email', 'jean.dupont@gmail.com')->exists())->toBeTrue();
});

it('contact form fails validation with missing fields', function () {
    $response = post(route('public.contact.store', ['locale' => 'fr']), []);

    $response->assertSessionHasErrors(['full_name', 'email', 'message']);
});
