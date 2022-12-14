<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $fillable = [
        'sender_id',
        'resever_id',
        'message',
    ];

    use HasFactory;
}
