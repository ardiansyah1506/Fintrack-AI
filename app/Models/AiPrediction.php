<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiPrediction extends Model {
    protected $fillable = ['prediction_type', 'title', 'description', 'confidence', 'generated_at', 'status'];
    protected $casts = ['generated_at' => 'datetime', 'confidence' => 'decimal:2'];
}
