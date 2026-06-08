<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\ContactMessageRequest;
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
        Mail::to($admins)->send(new ContactMessageMail($message));
        Mail::to(config('mail.reply_to.address'))->send(new ContactMessageMail($message));

        return redirect()->back()->with('send', __('/public/contact.send'));
    }
}
