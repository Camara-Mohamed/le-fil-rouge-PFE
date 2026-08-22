<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactConfirmationMail;
use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function store(ContactMessageRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        try {
            $admins = User::where('role', UserRoles::ADMIN)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewContactMessageNotification($message));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new NewContactMessageNotification($message));
            Mail::to($message->email)->send(new ContactConfirmationMail($message));
        } catch (\Throwable) {
        }

        return redirect()->back()->with('send', __('/public/contact.send'));
    }
}
