<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\VolunteerDemandeRequest;
use App\Mail\VolunteerRequestConfirmationMail;
use App\Models\User;
use App\Models\VolunteerRequest;
use App\Notifications\NewVolunteerRequestNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class VolunteerRequestController extends Controller
{
    public function index()
    {
        return view('public.volunteer');
    }

    public function store(VolunteerDemandeRequest $request)
    {
        $volunteer = VolunteerRequest::create($request->validated());

        try {
            $admins = User::where('role', UserRoles::ADMIN)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewVolunteerRequestNotification($volunteer));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new NewVolunteerRequestNotification($volunteer));
            Mail::to($volunteer->email)->send(new VolunteerRequestConfirmationMail($volunteer));
        } catch (\Throwable) {
        }

        return redirect()->back()->with('send', __('/public/volunteer-request.send'));
    }
}
