<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    protected $fillable = ['title', 'period', 'content', 'generated_at', 'type'];
    protected $casts = ['generated_at' => 'datetime'];
}
