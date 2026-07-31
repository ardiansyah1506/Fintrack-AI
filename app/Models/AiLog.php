<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiLog extends Model {
    protected $fillable = ['request', 'response', 'model', 'duration', 'status'];
    protected $casts = ['request' => 'array', 'response' => 'array', 'duration' => 'decimal:4'];
}
