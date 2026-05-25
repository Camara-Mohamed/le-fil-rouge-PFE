<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user?->isAdmin()) {
            $announcements = Announcement::query()
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        } else {
            $announcements = Announcement::query()
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(4);
        }

        return view('public.announcements.index', compact('announcements'));
    }

    public function show(string $locale, Announcement $announcement)
    {
        return view('public.announcements.show', compact('announcement', 'locale'));
    }
}
