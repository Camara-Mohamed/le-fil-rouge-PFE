<?php

use App\Models\Camp;
use App\Models\Training;
use App\Notifications\UpcomingEventNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $targetDate = Carbon::today()->addDays(7);

    $camps = Camp::with('acceptedRegisters.user')->whereDate('start_date', $targetDate)->get();
    foreach ($camps as $camp) {
        foreach ($camp->acceptedRegisters as $register) {
            $register->user->notify(new UpcomingEventNotification($camp));
        }
        Notification::route('mail', config('mail.reply_to.address'))->notify(new UpcomingEventNotification($camp));
    }

    $trainings = Training::with('acceptedRegisters.user')->whereDate('start_date', $targetDate)->get();
    foreach ($trainings as $training) {
        foreach ($training->acceptedRegisters as $register) {
            $register->user->notify(new UpcomingEventNotification($training));
        }
        Notification::route('mail', config('mail.reply_to.address'))->notify(new UpcomingEventNotification($training));
    }
})->daily()->name('send-upcoming-event-reminders');
