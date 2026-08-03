<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class UpdateBillIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'update_bill', 
            'status' => 'success',
            'intent' => 'UpdateBillIntent',
            'message' => 'Intent UpdateBillIntent executed successfully. Validating Dispatcher...'
        ];
    }
}