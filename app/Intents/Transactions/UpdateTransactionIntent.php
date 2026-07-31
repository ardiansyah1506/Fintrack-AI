<?php
namespace App\Intents\Transactions;
use App\Intents\Contracts\IntentInterface;
use App\Services\TransactionService;
use InvalidArgumentException;
class UpdateTransactionIntent implements IntentInterface {
    public function __construct(protected TransactionService $transactionService) {}
    public function handle(array $params): array {
        $id = $params['id'] ?? null;
        if (empty($id)) {
            $latest = $this->transactionService->getLatestTransaction();
            if (!$latest) throw new InvalidArgumentException("Belum ada transaksi yang dapat diperbarui.");
            $id = $latest->id;
        }
        if (empty($params['category']) && !empty($params['category_name'])) { $params['category'] = $params['category_name']; }
        $transaction = $this->transactionService->updateTransaction($id, $params);
        return ['intent' => 'update_transaction', 'status' => 'success', 'message' => 'Transaksi berhasil diperbarui', 'transaction' => $transaction];
    }
}