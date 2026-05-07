<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\VolunteerDemandeRequest;
use App\Mail\VolunteerRequestConfirmationMail;
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

        $admins = User::where('role', UserRoles::ADMIN)->get();
        Mail::to($admins)->send(new VolunteerRequestMail($volunteer));

        Mail::to($volunteer->email)->send(new VolunteerRequestConfirmationMail($volunteer));

        return redirect()->back()->with('send', __('/public/volunteer-request.send'));
    }
}
