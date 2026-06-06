<?php

namespace App\Http\Controllers;

use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        return view('public.trainings.index');
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
