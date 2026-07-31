<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiWarning extends Model {
    protected $fillable = ['title', 'description', 'severity', 'resolved'];
    protected $casts = ['resolved' => 'boolean'];
}
