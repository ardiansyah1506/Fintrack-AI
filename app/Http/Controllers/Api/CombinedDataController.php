<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\RecurringBill;
use App\Models\SavingGoal;
use App\Models\Transaction;
use App\Traits\ApiResponse;

class CombinedDataController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/combined-data
     * Mengambil semua data budgets, transactions, saving goals, dan bills.
     */
    public function index()
    {
        $data = [
            'budgets' => Budget::all(),
            'transactions' => Transaction::orderBy('transaction_date', 'desc')->get(),
            'saving_goals' => SavingGoal::all(),
            'bills' => RecurringBill::all(),
        ];

        return $this->successResponse(
            $data,
            'Berhasil mengambil semua data',
            200,
            'combined_data',
            'data'
        );
    }
}
