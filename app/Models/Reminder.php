<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['name', 'description', 'due_date', 'due_time', 'repeat', 'priority', 'status', 'telegram_notification'];
    protected $casts = ['due_date' => 'date', 'telegram_notification' => 'boolean'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
