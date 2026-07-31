<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingGoal extends Model
{
    protected $fillable = ['title', 'target_amount', 'current_amount', 'deadline', 'icon', 'status'];
    protected $casts = ['target_amount' => 'decimal:2', 'current_amount' => 'decimal:2', 'deadline' => 'date'];
}
