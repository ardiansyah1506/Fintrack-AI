<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiPrediction extends Model
{
    protected $fillable = ['prediction_type', 'name', 'description', 'confidence', 'generated_at', 'status'];
    protected $casts = ['generated_at' => 'datetime', 'confidence' => 'decimal:2'];

    public function getTitleAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
