<?php
namespace App\Intents\Transactions;
use App\Intents\Contracts\IntentInterface;
use App\Services\TransactionService;
use InvalidArgumentException;
class DeleteTransactionIntent implements IntentInterface {
    public function __construct(protected TransactionService $transactionService) {}
    public function handle(array $params): array {
        $id = $params['id'] ?? null;
        if (empty($id)) {
            $latest = $this->transactionService->getLatestTransaction();
            if (!$latest) throw new InvalidArgumentException("Belum ada transaksi yang dapat dihapus.");
            $id = $latest->id;
        }
        $this->transactionService->deleteTransaction($id);
        return ['intent' => 'delete_transaction', 'status' => 'success', 'message' => "Transaksi ID {$id} berhasil dihapus"];
    }
}