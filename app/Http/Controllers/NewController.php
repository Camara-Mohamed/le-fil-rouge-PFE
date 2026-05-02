<?php

namespace App\Http\Controllers;

use App\Models\New;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class NewController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', new::class);

        return new::all();
        }

    public function store(Request $request)
    {
        $this->authorize('create', new::class);

        $data = $request->validate([

        ]);

        return new::create($data);
        }

    public function show(new $new)
        {
        $this->authorize('view', $new);

        return $new;
        }

public
function update(Request $request, new $new)
        {
            $this->authorize('update', $new);

            $data = $request->validate([

            ]);

            $new->update($data);

            return $new;
        }

        public function destroy(new $new)
        {
            $this->authorize('delete', $new);

            $new->delete();

            return response()->json();
        }
    }
