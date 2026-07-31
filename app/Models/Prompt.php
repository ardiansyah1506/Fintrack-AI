<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Prompt extends Model {
    protected $fillable = ['name', 'prompt', 'active', 'version'];
    protected $casts = ['active' => 'boolean', 'version' => 'integer'];
}
