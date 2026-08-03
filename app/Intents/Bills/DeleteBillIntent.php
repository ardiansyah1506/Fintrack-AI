<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class DeleteBillIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'delete_bill', 
            'status' => 'success',
            'intent' => 'DeleteBillIntent',
            'message' => 'Intent DeleteBillIntent executed successfully. Validating Dispatcher...'
        ];
    }
}