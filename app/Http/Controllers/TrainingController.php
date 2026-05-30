<?php

namespace App\Http\Controllers;

use App\Enums\TrainingStatus;
use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user?->isAdmin()) {
            $trainings = Training::query()
                ->orderBy('start_date', 'desc')
                ->paginate(6);

        } elseif ($user?->isCoordinateur()) {
            $trainings = Training::query()
                ->where('status', TrainingStatus::PUBLISHED)
                ->orWhere('user_id', $user->id)
                ->orWhereHas('registers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        } elseif ($user) {
            $trainings = Training::query()
                ->where('status', TrainingStatus::PUBLISHED)
                ->orWhere('user_id', $user->id)
                ->orWhereHas('registers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        } else {
            $trainings = Training::query()
                ->where('status', TrainingStatus::PUBLISHED)
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        }

        return view('public.trainings.index', compact('trainings'));
    }

    public function show(string $locale, Training $training)
    {
        $user = auth()->user();

        if (! $training->isPublished()) {
            if (! $user || (! $user->isAdmin() && $user->id !== $training->user_id)) {
                abort(403);
            }
        }

        $training->load('galeries');

        return view('public.trainings.show', compact('training', 'locale'));
    }
}
