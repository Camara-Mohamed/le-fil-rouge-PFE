<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\VolunteerRequestController;
use App\Http\Middleware\SetLocale;

Route::prefix('{locale}')
    ->middleware(SetLocale::class)
    ->group(function () {

        // Page d'accueil
        Route::get('/', [HomeController::class, 'index'])
            ->name('public.home');

        // Pages des formations
        Route::get('/trainings', [TrainingController::class, 'index'])
            ->name('public.trainings.index');
        Route::get('/trainings/{training}', [TrainingController::class, 'show'])
            ->name('public.trainings.show');

        // Pages des stages et séjours (camps)
        Route::get('/camps', [CampController::class, 'index'])
            ->name('public.camps.index');
        Route::get('/camps/{camp}', [CampController::class, 'show'])
            ->name('public.camps.show');

        // Page à propos
        Route::get('/about', function () {
            return view('public.about');
        })->name('public.about');

        // Pages des actualités
        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('public.announcements.index');
        Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])
            ->name('public.announcements.show');

        // Page de contact
        Route::get('/contact', [ContactMessageController::class, 'index'])
            ->name('public.contact');
        Route::post('/contact', [ContactMessageController::class, 'store'])->name('public.contact.store');

        // Page devenir volontaire
        Route::get('/volunteer', [VolunteerRequestController::class, 'index'])
            ->name('public.volunteer');
        Route::post('/volunteer', [VolunteerRequestController::class, 'store'])
            ->name('public.volunteer.store');
    });
