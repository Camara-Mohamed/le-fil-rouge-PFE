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

        $allTrainings = null;

        if (auth()->user()?->isAdmin()) {
            $allTrainings = Training::query()
                ->orderBy('start_date', 'desc')
                ->paginate(6);

        } elseif (auth()->user()?->isFormateur()) {
            $allTrainings = Training::query()
                ->where('user_id', auth()->id())
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        }

        return view('public.trainings.index', compact('trainings', 'allTrainings'));
    }

    public function show(string $locale, Training $training)
    {
        return view('public.trainings.show', compact('training', 'locale'));
    }
}
