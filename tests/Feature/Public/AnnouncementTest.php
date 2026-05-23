<?php

use App\Models\Announcement;

use function Pest\Laravel\get;

it('a guest can show announcements', function () {
    $announcement = Announcement::factory()->create(['title' => 'Mon announcement']);

    get(route('public.announcements.index', ['locale' => app()->getLocale()]))
        ->assertSee('Mon announcement');
});

it('a guest can search a announcement', function () {
    Announcement::factory()->create(['title' => 'Mon announcement']);
    Announcement::factory()->create(['title' => 'Une autre announcement']);

    get(route('public.announcements.index', ['locale' => app()->getLocale(), 'search' => 'mon']))
        ->assertSee('Mon announcement')
        ->assertDontSee('Un autre announcement');
});

it('guest can access announcement show page', function () {
    $announcement = Announcement::factory()->create();

    get(route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement]))
        ->assertSee($announcement->title);
});
