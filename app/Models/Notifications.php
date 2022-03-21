<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    const TYPE_SMS   = 'sms';
    const TYPE_EMAIL = 'email';

    use HasFactory;
}
