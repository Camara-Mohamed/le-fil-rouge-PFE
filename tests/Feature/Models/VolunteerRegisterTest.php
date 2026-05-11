<?php

use App\Enums\VolunteerRequestStatus;
use App\Models\VolunteerRequest;

it('returns the user full name', function () {
    $request = new VolunteerRequest([
        'first_name' => 'Dylan',
        'last_name'  => 'Piquin',
    ]);

    expect($request->fullName())->toBe('Dylan Piquin');
});

it('returns true if the request of the volunteer is pending', function () {
    $request = new VolunteerRequest(['status' => VolunteerRequestStatus::PENDING]);

    expect($request->isPending())->toBeTrue();
});

it('returns true if the request of the volunteer is rejected', function () {
    $request = new VolunteerRequest(['status' => VolunteerRequestStatus::REJECTED]);

    expect($request->isPending())->toBeFalse();
});

it('returns true if the request of the volunteer is accepted', function () {
    $request = new VolunteerRequest(['status' => VolunteerRequestStatus::ACCEPTED]);

    expect($request->isPending())->toBeFalse();
});
