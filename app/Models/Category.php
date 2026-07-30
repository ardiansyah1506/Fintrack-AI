<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'color',
        'icon',
    ];

    /**
     * Get the transactions for the category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category', 'name');
    }
}
