<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['category', 'amount', 'period'];
    protected $casts = ['amount' => 'decimal:2'];
}
