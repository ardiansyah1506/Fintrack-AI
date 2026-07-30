<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected TransactionService $transactionService
    ) {}

    /**
     * GET /api/transactions
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

        $perPage = (int) $request->query('per_page', 15);
        $transactions = $this->transactionService->getPaginatedTransactions($filters, $perPage);
        $summary = $this->transactionService->getFilteredSummary($filters);

        return $this->successResponse([
            'summary' => $summary,
            'items' => TransactionResource::collection($transactions),
            'pagination' => [
                'total' => $transactions->total(),
                'per_page' => $transactions->perPage(),
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
            ]
        ], 'Berhasil mengambil data transaksi');
    }

    /**
     * POST /api/transactions
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction($request->validated());

        return $this->successResponse(
            new TransactionResource($transaction),
            'Transaksi berhasil dicatat',
            201
        );
    }

    /**
     * GET /api/transactions/{id}
     */
    public function show($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);

        return $this->successResponse(
            new TransactionResource($transaction),
            'Berhasil mengambil detail transaksi'
        );
    }

    /**
     * PUT /api/transactions/{id}
     */
    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaction = $this->transactionService->updateTransaction($id, $request->validated());

        return $this->successResponse(
            new TransactionResource($transaction),
            'Transaksi berhasil diperbarui'
        );
    }

    /**
     * DELETE /api/transactions/{id}
     */
    public function destroy($id)
    {
        $this->transactionService->deleteTransaction($id);

        return $this->successResponse(
            null,
            'Transaksi berhasil dihapus'
        );
    }
}
