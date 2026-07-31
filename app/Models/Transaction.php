<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'type',
        'category',
        'amount',
        'description',
        'notes',
        'source',
        'created_by',
        'attachment_url',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the category model associated with the transaction name.
     */
    public function categoryModel()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }
}
