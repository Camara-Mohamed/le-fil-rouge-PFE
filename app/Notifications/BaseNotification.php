<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    // 5min, 30min, 1h
    public array $backoff = [300, 1800, 3600];

    public function failed(\Throwable $e): void
    {
        Log::error(static::class.' failed after all retries', [
            'error' => $e->getMessage(),
        ]);
    }
}
