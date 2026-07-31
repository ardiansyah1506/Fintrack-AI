<?php

namespace App\Intents\Bills;

use App\Intents\IntentInterface;

class ListBillsIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ListBillsIntent',
            'message' => 'Intent ListBillsIntent executed successfully. Validating Dispatcher...'
        ];
    }
}