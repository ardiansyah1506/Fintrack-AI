<?php

namespace App\Intents\Transactions;

use App\Intents\IntentInterface;

class UpdateTransactionIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'UpdateTransactionIntent',
            'message' => 'Intent UpdateTransactionIntent executed successfully. Validating Dispatcher...'
        ];
    }
}