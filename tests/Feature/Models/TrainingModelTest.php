<?php

use App\Enums\TrainingStatus;
use App\Models\Training;

it('returns true if the training status is draft', function () {
    $training = Training::factory()->make(['status' => TrainingStatus::DRAFT]);

    expect($training->isDraft())->toBeTrue();
});

it('returns true if the training status is published', function () {
    $training = Training::factory()->make(['status' => TrainingStatus::PUBLISHED]);

    expect($training->isPublished())->toBeTrue()
        ->and($training->isDraft())->toBeFalse();
});

it('returns true if the training status is pending', function () {
    $training = Training::factory()->make(['status' => TrainingStatus::PENDING]);

    expect($training->isPending())->toBeTrue();
});

it('returns true if the training status is refused', function () {
    $training = Training::factory()->make(['status' => TrainingStatus::REFUSED]);

    expect($training->isRefused())->toBeTrue();
});

it('returns true if the training status is confirmed', function () {
    $training = Training::factory()->make(['status' => TrainingStatus::CONFIRMED]);

    expect($training->isConfirmed())->toBeTrue();
});
