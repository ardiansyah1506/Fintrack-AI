<?php

namespace App\Intents\Transactions;

use App\Intents\IntentInterface;

class CreateTransactionIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'CreateTransactionIntent',
            'message' => 'Intent CreateTransactionIntent executed successfully. Validating Dispatcher...'
        ];
    }
}