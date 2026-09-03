<?php

namespace App\Http\Controllers;

use App\Models\Camp;

class CampController extends Controller
{
    public function index()
    {
        return view('public.camps.index');
    }

    public function show(string $locale, Camp $camp)
    {
        $user = auth()->user();

        $isVisible = $camp->isPublished()
            || $camp->isConfirmed()
            || ($user && ($user->isAdmin() || $user->id === $camp->user_id || $camp->acceptedRegisters()->where('user_id', $user->id)->exists()));

        if (! $isVisible) {
            abort(403);
        }

        $myRegister = $camp
            ->acceptedRegisters()
            ->where('user_id', auth()->id())
            ->first();

        $camp->load(['galeries', 'acceptedRegisters.user']);

        return view('public.camps.show', compact('camp', 'locale', 'myRegister'));
    }
}
