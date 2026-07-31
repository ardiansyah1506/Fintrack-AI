<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ChatHistory extends Model {
    protected $fillable = ['role', 'message', 'intent', 'parameters', 'response'];
    protected $casts = ['parameters' => 'array'];
}
