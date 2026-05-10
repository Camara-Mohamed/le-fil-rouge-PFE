<?php

namespace App\Http\Controllers;

use App\Enums\CampStatus;
use App\Enums\TrainingStatus;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Training;

class HomeController extends Controller
{
    public function index()
    {
        $trainings = Training::query()
            ->where('status', TrainingStatus::PUBLISHED)
            ->limit(3)
            ->get();

        $camps = Camp::query()
            ->where('status', CampStatus::PUBLISHED)
            ->get();

        $announcements = Announcement::query()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('public.home', compact('trainings', 'announcements', 'camps'));
    }
}
