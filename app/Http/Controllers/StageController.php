<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class StageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Stage::class);

        return Stage::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Stage::class);

        $data = $request->validate([

        ]);

        return Stage::create($data);
    }
}
