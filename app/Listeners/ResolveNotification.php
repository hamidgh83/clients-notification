<?php

namespace App\Listeners;

use App\Events\NotificationSent;
use App\Models\Notifications;
use App\Services\NotificationService;

class ResolveNotification
{
    protected NotificationService $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationSent $event)
    {
        $this->notificationService->update($event->notification, [
            'status' => Notifications::STATUS_SENT,
        ]);
    }
}
