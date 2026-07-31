<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['title', 'description', 'due_date', 'due_time', 'repeat', 'priority', 'status', 'telegram_notification'];
    protected $casts = ['due_date' => 'date', 'telegram_notification' => 'boolean'];
}
