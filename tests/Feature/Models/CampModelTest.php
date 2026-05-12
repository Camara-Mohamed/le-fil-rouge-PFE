<?php

use App\Enums\CampStatus;
use App\Models\Camp;

it('returns true if the Camp status is draft', function () {
    $Camp = Camp::factory()->make(['status' => CampStatus::DRAFT]);

    expect($Camp->isDraft())->toBeTrue();
});

it('returns true if the Camp status is published', function () {
    $Camp = Camp::factory()->make(['status' => CampStatus::PUBLISHED]);

    expect($Camp->isPublished())->toBeTrue()
        ->and($Camp->isDraft())->toBeFalse();
});

it('returns true if the Camp status is pending', function () {
    $Camp = Camp::factory()->make(['status' => CampStatus::PENDING]);

    expect($Camp->isPending())->toBeTrue();
});

it('returns true if the Camp status is refused', function () {
    $Camp = Camp::factory()->make(['status' => CampStatus::REFUSED]);

    expect($Camp->isRefused())->toBeTrue();
});

it('returns true if the Camp status is confirmed', function () {
    $Camp = Camp::factory()->make(['status' => CampStatus::CONFIRMED]);

    expect($Camp->isConfirmed())->toBeTrue();
});
