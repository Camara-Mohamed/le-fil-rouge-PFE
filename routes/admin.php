<?php

use App\Http\Middleware\SetLocale;

Route::prefix('{locale}')
    ->middleware([SetLocale::class, 'auth'])
    ->group(function () {

        // Page d'accueil (dashboard)
        Route::livewire('/dashboard', 'pages::dashboard')
            ->name('admin.dashboard');

        // Pages de gestion des formations
        Route::livewire('/trainings/create', 'pages::trainings.create')
            ->middleware('can:manage-training')
            ->name('admin.trainings.create');
        Route::livewire('/trainings/{training}/edit', 'pages::trainings.edit')
            ->middleware('can:manage-training')
            ->name('admin.trainings.edit');

        // Pages de gestion des stages et séjours (camps)
        Route::livewire('/camps/create', 'pages::camps.create')
            ->middleware('can:manage-camp')
            ->name('admin.camps.create');
        Route::livewire('/camps/{camp}/edit', 'pages::camps.edit')
            ->middleware('can:manage-camp')
            ->name('admin.camps.edit');

        // Pages de gestion des actualités
        Route::livewire('/announcements/create', 'pages::announcements.create')
            ->middleware('can:manage-announcement')
            ->name('admin.announcements.create');
        Route::livewire('/announcements/{announcement}/edit', 'pages::announcements.edit')
            ->middleware('can:manage-announcement')
            ->name('admin.announcements.edit');

        // Pages de gestion des membres
        Route::livewire('/members', 'pages::members.index')
            ->middleware('can:manage-members')
            ->name('admin.members.index');
        Route::livewire('/members/create', 'pages::members.create')
            ->middleware('can:manage-members')
            ->name('admin.members.create');
        Route::livewire('/members/{member}', 'pages::members.show')
            ->middleware('can:manage-members')
            ->name('admin.members.show');
        Route::livewire('/members/{member}/edit', 'pages::members.edit')
            ->middleware('can:manage-members')
            ->name('admin.members.edit');

        // Page de gestion des messages
        Route::livewire('/messages', 'pages::messages')
            ->middleware('can:manage-messages')
            ->name('admin.messages.index');

        // Page de gestion du profil utilisateur
        Route::livewire('/my-profile', 'pages::profile')
            ->middleware('can:access-profile')
            ->name('admin.profile');

        // Page de gestion des historiques de formations ou de camps
        Route::livewire('/my-enrollments', 'pages::enrollments')
            ->name('admin.enrollments');

        // Page d'aide pour utilisation du site
        Route::livewire('/how-to-use', 'pages::help')
            ->name('admin.help');

        // Page des notifications
        Route::livewire('/my-notifications', 'pages::notifications')
            ->name('admin.notifications');
    });
