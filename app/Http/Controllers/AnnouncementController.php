<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::query()
            ->orderBy('published_at', 'desc')
            ->paginate(4);

        return view('public.announcements.index', compact('announcements'));
    }

    public function show(string $locale, Announcement $announcement)
    {
        return view('public.announcements.show', compact('announcement'));
    }

    public function create()
    {
        return view('pages.announcements.⚡create.create');
    }
}
