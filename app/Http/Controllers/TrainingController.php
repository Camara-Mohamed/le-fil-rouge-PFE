<?php

namespace App\Http\Controllers;

use App\Enums\TrainingStatus;
use App\Models\Training;
use Illuminate\Support\Carbon;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::query()
            ->where('status', TrainingStatus::PUBLISHED)
            ->whereDate('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'desc')
            ->paginate(6);

        return view('public.trainings.index', compact('trainings'));
    }

    public function show(string $locale, Training $training)
    {
        return view('public.trainings.show', compact('training', 'locale'));
    }
}
