<?php

namespace App\Intents\Budgets;

use App\Intents\IntentInterface;

class CreateBudgetIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'CreateBudgetIntent',
            'message' => 'Intent CreateBudgetIntent executed successfully. Validating Dispatcher...'
        ];
    }
}