<?php

use App\Enums\RegisterStatus;
use App\Models\CampRegister;

it('returns true if register have pending status', function () {
    $register = new CampRegister(['status' => RegisterStatus::PENDING]);

    expect($register->isPending())->toBeTrue();
});

it('returns true if register have accepted status', function () {
    $register = new CampRegister(['status' => RegisterStatus::ACCEPTED]);

    expect($register->isAccepted())->toBeTrue();
});

it('returns true if register have refused status', function () {
    $register = new CampRegister(['status' => RegisterStatus::REFUSED]);

    expect($register->isRefused())->toBeTrue();
});
