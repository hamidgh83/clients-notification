<?php

namespace App\Repositories;

use App\Models\Notifications;
use App\Repositories\Eloquent\BaseRepository;

class NotificationRepository extends BaseRepository
{
    protected function getModelName()
    {
        return Notifications::class;        
    }
}