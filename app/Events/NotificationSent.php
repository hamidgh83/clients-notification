<?php

namespace App\Events;

use App\Models\Notifications;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent
{
    use Dispatchable;
    use SerializesModels;

    public Notifications $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Notifications $notification)
    {
        $this->notification = $notification;
    }
}
