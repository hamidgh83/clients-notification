<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    const TYPE_SMS       = 'sms';
    const TYPE_EMAIL     = 'email';
    const STATUS_PENDING = 'pending';
    const STATUS_SENT    = 'sent';

    protected $fillable = [
        "user_id",
        "channel",
        "content",
        "status",
    ];

    use HasFactory;
}
