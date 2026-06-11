<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactConfirmationMail;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function store(ContactMessageRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        $admins = User::where('role', UserRoles::ADMIN)->get();

        foreach ($admins as $admin){
            Mail::to($admin->email)->send(new ContactMessageMail($message));
        }

        Mail::to(config('mail.notification_for_mails'))->send(new ContactMessageMail($message));

        Mail::to($message->email)->send(new ContactConfirmationMail($message));

        return redirect()->back()->with('send', __('/public/contact.send'));
    }
}
