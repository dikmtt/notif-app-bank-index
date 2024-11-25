<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subscriber_id',
        'username',
        'name',
        'email'
    ];
}
