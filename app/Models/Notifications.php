<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    public const TYPE_SMS       = 'sms';
    public const TYPE_EMAIL     = 'email';
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT    = 'sent';

    protected $fillable = [
        'user_id',
        'channel',
        'content',
        'status',
    ];
}
