<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiRecommendation extends Model
{
    protected $fillable = ['name', 'description', 'priority', 'status'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
