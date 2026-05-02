<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Formation::class);

        return Formation::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Formation::class);

        $data = $request->validate([

        ]);

        return Formation::create($data);
    }
}
