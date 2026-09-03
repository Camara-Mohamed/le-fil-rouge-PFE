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

        $isVisible = $training->isPublished()
            || $training->isConfirmed()
            || ($user && ($user->isAdmin() || $user->id === $training->user_id || $training->acceptedRegisters()->where('user_id', $user->id)->exists()));

        if (! $isVisible) {
            abort(403);
        }

        $training->load(['galeries', 'acceptedRegisters.user']);

        return view('public.trainings.show', compact('training', 'locale'));
    }
}
