<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('public.announcements.index');
    }

    public function show(string $locale, Announcement $announcement, User $user)
    {
        if (is_null($announcement->published_at)) {
            if ($user?->isAdmin()) {
                abort(403);
            }
        }

        $announcement->load('galeries');

        return view('public.announcements.show', compact('announcement', 'locale'));
    }
}
