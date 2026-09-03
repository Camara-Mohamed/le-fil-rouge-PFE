<?php

namespace App\Http\Controllers;

use App\Enums\TrainingStatus;
use App\Models\Announcement;
use App\Models\Training;

class HomeController extends Controller
{
    public function index()
    {
        $trainings = Training::query()
            ->where('status', TrainingStatus::PUBLISHED)
            ->limit(3)
            ->get();

        $announcements = Announcement::query()
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('public.home', compact('trainings', 'announcements'));
    }
}
