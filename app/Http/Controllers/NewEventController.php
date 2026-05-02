<?php

namespace App\Http\Controllers;

use App\Models\NewEvent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class NewEventController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', NewEvent::class);

        return NewEvent::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', NewEvent::class);

        $data = $request->validate([

        ]);

        return NewEvent::create($data);
    }

    public function show(NewEvent $newEvent)
    {
        $this->authorize('view', $newEvent);

        return $newEvent;
    }

    public function update(Request $request, NewEvent $newEvent)
    {
        $this->authorize('update', $newEvent);

        $data = $request->validate([

        ]);

        $newEvent->update($data);

        return $newEvent;
    }

    public function destroy(NewEvent $newEvent)
    {
        $this->authorize('delete', $newEvent);

        $newEvent->delete();

        return response()->json();
    }
}
