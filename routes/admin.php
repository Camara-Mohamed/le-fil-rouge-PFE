<?php

use App\Http\Middleware\SetLocale;

Route::prefix('{locale}')
    ->middleware([SetLocale::class, 'auth'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
