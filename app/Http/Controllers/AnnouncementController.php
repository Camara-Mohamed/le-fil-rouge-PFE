<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('public.announcements.index');
    }

    public function show(string $locale, Announcement $announcement)
    {
        if (is_null($announcement->published_at) && ! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $announcement->load(['galeries', 'user']);

        return view('public.announcements.show', compact('announcement', 'locale'));
    }
}
