<?php

namespace App\Http\Controllers;

use App\Enums\CampStatus;
use App\Enums\TrainingStatus;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Training;
use App\Models\User;

class AboutController extends Controller
{
    public function index()
    {
        $stats = [
            [
                'value' => now()->year - 2009 . ' ans',
                'label' => __('public/about.stat_years'),
            ],
            [
                'value' => '+' . Training::where('status', TrainingStatus::PUBLISHED)->count(),
                'label' => __('public/about.stat_trainings'),
            ],
            [
                'value' => '+' . Camp::where('status', CampStatus::PUBLISHED)->count(),
                'label' => __('public/about.stat_camps'),
            ],
            [
                'value' => '+' . User::count(),
                'label' => __('public/about.stat_members'),
            ],
        ];

        return view('public.about', compact('stats'));
    }
}
