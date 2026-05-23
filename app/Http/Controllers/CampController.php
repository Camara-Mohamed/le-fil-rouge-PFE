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

        return view('public.camps.index', compact('camps'));
    }

    public function show(string $locale, Camp $camp)
    {
        return view('public.camps.show', compact('camp', 'locale'));
    }
}
