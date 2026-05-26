<?php

use App\Http\Controllers\ExportController;
use App\Http\Middleware\SetLocale;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::prefix('{locale}')
    ->middleware([SetLocale::class, 'auth', SubstituteBindings::class])
    ->group(function () {

        Route::get('/trainings/{training}/pdf', [ExportController::class, 'resumeTraining'])
            ->middleware('can:manage-training')
            ->name('admin.trainings.pdf');

        Route::get('/camps/{camp}/pdf', [ExportController::class, 'resumeCamp'])
            ->middleware('can:manage-camp')
            ->name('admin.camps.pdf');

        Route::get('/camps/{camp}/registers/{register}/pdf', [ExportController::class, 'contract'])
            ->name('admin.camps.register.pdf');
    });
