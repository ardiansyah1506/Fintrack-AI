<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringBill extends Model
{
    protected $fillable = ['name', 'category', 'amount', 'billing_date', 'repeat', 'auto_create_transaction', 'reminder_before', 'status'];
    protected $casts = ['amount' => 'decimal:2', 'auto_create_transaction' => 'boolean'];
}
