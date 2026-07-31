<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class DeleteBillIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'DeleteBillIntent',
            'message' => 'Intent DeleteBillIntent executed successfully. Validating Dispatcher...'
        ];
    }
}