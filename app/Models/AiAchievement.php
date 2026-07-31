<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiAchievement extends Model {
    protected $fillable = ['title', 'description', 'reward', 'achieved_at'];
    protected $casts = ['achieved_at' => 'datetime'];
}
