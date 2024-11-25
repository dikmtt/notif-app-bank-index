<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'channel_type',
        'message_id',
        'category',
        'duration',
        'interval',
        'sent_at',
        'is_recurring',
        'scheduled_at',
        'is_response',
        'response_by',
        'users_sent_to',
    ];

    public function message() {
        return $this->belongsTo(Message::class);
    }
}
