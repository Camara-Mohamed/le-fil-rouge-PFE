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

        if (! $camp->isPublished()) {
            if (! $user || (! $user->isAdmin() && $user->id !== $camp->user_id)) {
                abort(403);
            }
        }

        $myRegister = $camp
            ->acceptedRegisters()
            ->where('user_id', auth()->id())
            ->first();

        $camp->load('galeries');

        return view('public.camps.show', compact('camp', 'locale', 'myRegister'));
    }
}
