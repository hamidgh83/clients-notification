<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\GetNotificationsRequest;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notifications;
use App\Services\NotificationService;

class NotificationsController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Create a notification.
     *
     * @param CreateNotificationRequest $request
     * @return NotificationResource
     */
    public function create(CreateNotificationRequest $request): NotificationResource
    {
        $notification = $this->notificationService->create($request->validated());

        return NotificationResource::make($notification);
    }

    /**
     * Get an identified notification.
     *
     * @param Notifications $notification
     * @return NotificationResource
     */
    public function get(Notifications $notification): NotificationResource
    {
        return NotificationResource::make($notification);
    }

    /**
     * Get a list of all created notifications.
     *
     * @param GetNotificationsRequest $request
     * @return NotificationCollection
     */
    public function getAll(GetNotificationsRequest $request): NotificationCollection
    {
        return NotificationCollection::make(
            $this->notificationService->getAll($request->get('clientId'))
        );
    }
}
