<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\VolunteerDemandeRequest;
use App\Mail\VolunteerRequestMail;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Support\Facades\Mail;

class VolunteerRequestController extends Controller
{
    public function index()
    {
        return view('public.volunteer');
    }

    public function store(VolunteerDemandeRequest $request)
    {
        $volunteer = VolunteerRequest::create($request->validated());

        $admins = User::where('role', UserRole::ADMIN)->get();
        Mail::to($admins)->send(new VolunteerRequestMail($volunteer));

        return redirect()->back()->with('send', __('/public/volunteer-request.send'));
    }
}
