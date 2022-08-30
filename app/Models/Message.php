<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_by',
        'job_id',
        'user_id',
        'conversation_id',
        'text',
        'is_read'
    ];
}