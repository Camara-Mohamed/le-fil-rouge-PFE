<?php

namespace App\Notifications;

use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        $channels = ['database', 'broadcast'];

        if (! method_exists($notifiable, 'wantsEmailNotifications') || $notifiable->wantsEmailNotifications()) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function broadcastType(): string
    {
        return 'notification.received';
    }

    protected function publicUrl(Model $model, string $locale = 'fr'): ?string
    {
        try {
            if ($model instanceof Training) {
                return route('public.trainings.show', ['locale' => $locale, 'training' => $model->slug]);
            }

            if ($model instanceof Camp) {
                return route('public.camps.show', ['locale' => $locale, 'camp' => $model->slug]);
            }

            if ($model instanceof Announcement) {
                return route('public.announcements.show', ['locale' => $locale, 'announcement' => $model->slug]);
            }
        } catch (\Throwable) {
            // route indisponible en contexte queue
        }

        return null;
    }
}
