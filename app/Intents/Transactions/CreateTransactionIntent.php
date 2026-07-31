<?php
namespace App\Intents\Transactions;
use App\Intents\Contracts\IntentInterface;
use App\Services\TransactionService;
use Carbon\Carbon;
class CreateTransactionIntent implements IntentInterface {
    public function __construct(protected TransactionService $transactionService) {}
    public function handle(array $params): array {
        if (empty($params['category']) && !empty($params['category_name'])) { $params['category'] = $params['category_name']; }
        if (empty($params['category'])) { $params['category'] = 'Lainnya'; }
        if (empty($params['transaction_date'])) {
            $dateVal = strtolower(trim($params['date'] ?? ''));
            if (in_array($dateVal, ['today', 'hari ini', ''])) $params['transaction_date'] = Carbon::now()->format('Y-m-d');
            elseif (in_array($dateVal, ['yesterday', 'kemarin'])) $params['transaction_date'] = Carbon::now()->subDay()->format('Y-m-d');
            else {
                try { $params['transaction_date'] = Carbon::parse($dateVal)->format('Y-m-d'); } catch (\Throwable $e) { $params['transaction_date'] = Carbon::now()->format('Y-m-d'); }
            }
        }
        $transaction = $this->transactionService->createTransaction($params);
        return ['intent' => 'create_transaction', 'status' => 'success', 'message' => 'Transaksi berhasil dicatat oleh Bot', 'transaction' => $transaction];
    }
}