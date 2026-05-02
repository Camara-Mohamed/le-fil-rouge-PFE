<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteerRequest;

class VolunteerRequestController extends Controller
{
    public function index()
    {
        return VolunteerRequest::all();
    }

    public function store(VolunteerRequest $request)
    {
        return VolunteerRequest::create($request->validated());
    }
}
