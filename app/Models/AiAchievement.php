<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiAchievement extends Model
{
    protected $fillable = ['name', 'description', 'reward', 'achieved_at'];
    protected $casts = ['achieved_at' => 'datetime'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
