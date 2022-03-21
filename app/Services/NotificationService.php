<?php

namespace App\Services;

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
        return $this->notificationRepository->create($data);
    }

    public function getAll(?int $clientId = null): LengthAwarePaginator
    {
        $conditions = $clientId ? [['user_id', '=', $clientId]] : [];
        
        return $this->notificationRepository->findAll($conditions);
    }
}
