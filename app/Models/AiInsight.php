<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    protected $fillable = ['name', 'period', 'content', 'generated_at', 'type'];
    protected $casts = ['generated_at' => 'datetime'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
