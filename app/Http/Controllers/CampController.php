<?php

namespace App\Http\Controllers;

use App\Enums\CampStatus;
use App\Models\Camp;
use Illuminate\Support\Carbon;

class CampController extends Controller
{
    public function index()
    {
        $camps = Camp::query()
            ->where('status', CampStatus::PUBLISHED)
            ->whereDate('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'desc')
            ->paginate(6);

        $allCamps = null;

        if (auth()->user()?->isAdmin()) {
            $allCamps = Camp::query()
                ->orderBy('start_date', 'desc')
                ->paginate(6);

        } elseif (auth()->user()?->isFormateur()) {
            $allCamps = Camp::query()
                ->where('user_id', auth()->id())
                ->orderBy('start_date', 'desc')
                ->paginate(6);
        }

        return view('public.camps.index', compact('camps', 'allCamps'));
    }

    public function show(string $locale, Camp $camp)
    {
        return view('public.camps.show', compact('camp', 'locale'));
    }
}
