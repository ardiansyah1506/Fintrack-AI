<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class ListBillsIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'list_bills', 
            'status' => 'success',
            'intent' => 'ListBillsIntent',
            'message' => 'Intent ListBillsIntent executed successfully. Validating Dispatcher...'
        ];
    }
}