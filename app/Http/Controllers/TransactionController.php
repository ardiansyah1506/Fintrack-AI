<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Services\CategoryService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of transactions with filters and pagination.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'type',
            'category',
            'period',
            'date_start',
            'date_end',
            'sort_by',
            'sort_dir',
        ]);

        $transactions = $this->transactionService->getPaginatedTransactions($filters, 10);
        $summary = $this->transactionService->getFilteredSummary($filters);
        $categories = $this->categoryService->getAllCategories();

        return view('transactions.index', compact('transactions', 'summary', 'categories', 'filters'));
    }

    /**
     * Store a newly created transaction.
     */
    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->createTransaction($request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Update the specified transaction.
     */
    public function update(UpdateTransactionRequest $request, $id)
    {
        $this->transactionService->updateTransaction($id, $request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy($id)
    {
        $this->transactionService->deleteTransaction($id);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
