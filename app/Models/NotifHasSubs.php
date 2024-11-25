<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifHasSubs extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'subscriber_id',
    ];
}
