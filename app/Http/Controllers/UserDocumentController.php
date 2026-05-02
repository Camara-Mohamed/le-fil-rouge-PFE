<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', UserDocument::class);

        return UserDocument::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', UserDocument::class);

        $data = $request->validate([

        ]);

        return UserDocument::create($data);
    }

    public function show(UserDocument $userDocument)
    {
        $this->authorize('view', $userDocument);

        return $userDocument;
    }

    public function update(Request $request, UserDocument $userDocument)
    {
        $this->authorize('update', $userDocument);

        $data = $request->validate([

        ]);

        $userDocument->update($data);

        return $userDocument;
    }

    public function destroy(UserDocument $userDocument)
    {
        $this->authorize('delete', $userDocument);

        $userDocument->delete();

        return response()->json();
    }
}
