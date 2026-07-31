<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class UpdateBillIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'UpdateBillIntent',
            'message' => 'Intent UpdateBillIntent executed successfully. Validating Dispatcher...'
        ];
    }
}