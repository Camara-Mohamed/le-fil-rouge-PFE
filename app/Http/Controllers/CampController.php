<?php

namespace App\Http\Controllers;

use App\Enums\CampStatus;
use App\Models\Camp;

class CampController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user?->isAdmin()) {
            $camps = Camp::query()
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        } elseif ($user?->isCoordinateur()) {
            $camps = Camp::query()
                ->where('status', CampStatus::PUBLISHED)
                ->orWhere('user_id', $user->id)
                ->orWhereHas('registers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        } elseif ($user) {
            $camps = Camp::query()
                ->where('status', CampStatus::PUBLISHED)
                ->orWhereHas('registers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        } else {
            $camps = Camp::query()
                ->where('status', CampStatus::PUBLISHED)
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        }

        return view('public.camps.index', compact('camps'));
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
