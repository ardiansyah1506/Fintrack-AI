<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class CreateBillIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'CreateBillIntent',
            'message' => 'Intent CreateBillIntent executed successfully. Validating Dispatcher...'
        ];
    }
}