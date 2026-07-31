<?php

namespace App\Intents\Transactions;

use App\Intents\IntentInterface;

class DeleteTransactionIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'DeleteTransactionIntent',
            'message' => 'Intent DeleteTransactionIntent executed successfully. Validating Dispatcher...'
        ];
    }
}