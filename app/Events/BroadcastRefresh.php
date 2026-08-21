<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class BroadcastRefresh implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public function __construct(public string $channelName) {}

    public function broadcastOn(): Channel
    {
        return new Channel($this->channelName);
    }

    public function broadcastAs(): string
    {
        return 'refreshed';
    }
}
