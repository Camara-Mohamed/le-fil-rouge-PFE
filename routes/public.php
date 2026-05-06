<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\VolunteerRequestController;
use App\Http\Middleware\SetLocale;

Route::prefix('{locale}')
    ->middleware(SetLocale::class)
    ->group(function () {

        // Page d'accueil
        Route::get('/', function () {
            return view('public.home');
        })->name('public.home');

        // Pages des formations
        Route::get('/trainings', function () {
            return view('public.trainings.index');
        })->name('public.trainings.index');
        Route::get('/trainings/{training}', function () {
            return view('public.trainings.show');
        })->name('public.trainings.show');

        // Pages des stages et séjours (camps)
        Route::get('/camps', function () {
            return view('public.camps.index');
        })->name('public.camps.index');
        Route::get('/camps/{camp}', function () {
            return view('public.camps.show');
        })->name('public.camps.show');

        // Page à propos
        Route::get('/about', function () {
            return view('public.about');
        })->name('public.about');

        // Pages des actualités
        Route::get('/announcements', function () {
            return view('public.announcements.index');
        })->name('public.announcements.index');
        Route::get('/announcements/{announcement}', function () {
            return view('public.announcements.show');
        })->name('public.announcements.show');

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
