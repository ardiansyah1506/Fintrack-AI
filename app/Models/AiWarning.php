<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiWarning extends Model
{
    protected $fillable = ['name', 'description', 'severity', 'resolved'];
    protected $casts = ['resolved' => 'boolean'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
