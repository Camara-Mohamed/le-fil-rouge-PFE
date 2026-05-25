<?php

namespace App\Http\Controllers;

use App\Enums\CampStatus;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Support\Carbon;

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
        return view('public.camps.show', compact('camp', 'locale'));
    }
}
