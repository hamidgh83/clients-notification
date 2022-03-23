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
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        $this->notificationService->update($event->notification, [
            'status' => Notifications::STATUS_SENT,
        ]);
    }
}
