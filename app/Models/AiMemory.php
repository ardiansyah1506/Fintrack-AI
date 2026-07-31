<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiMemory extends Model {
    protected $fillable = ['key', 'value', 'type', 'active'];
    protected $casts = ['active' => 'boolean'];
}
