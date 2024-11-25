<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQuery extends Model
{
    use HasFactory;

    protected $table = 'emailquery';

    protected $fillable = [
        'querystring',
        'targetsubid',
    ];

    public function sub() {
        return $this->hasOne(Subscriber::class, 'subscriber_id', 'targetsubid');
    }
}
