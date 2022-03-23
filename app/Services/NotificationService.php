<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Models\Notifications;
use App\Repositories\NotificationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function create(array $data)
    {
        $data['status'] = Notifications::STATUS_PENDING;
        $notification   = $this->notificationRepository->create($data);

        $this->dispatchNotificationJob($notification);

        return $notification;
    }

    public function update(Notifications $notification, array $data)
    {
        return $this->notificationRepository->update($notification, $data);
    }

    public function getAll(?int $clientId = null): LengthAwarePaginator
    {
        $conditions = $clientId ? [['user_id', '=', $clientId]] : [];
        
        return $this->notificationRepository->findAll($conditions);
    }

    protected function dispatchNotificationJob(Notifications $notification)
    {
        switch ($notification->channel) {
            case Notifications::TYPE_EMAIL:
            case Notifications::TYPE_SMS:
                SendNotificationJob::dispatch($notification->toArray())->onQueue($notification->channel);
                break;
        
            default:
                SendNotificationJob::dispatch($notification->toArray());
                break;
        }
    }
}
