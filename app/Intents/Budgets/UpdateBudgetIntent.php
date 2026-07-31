<?php

namespace App\Intents\Budgets;

use App\Intents\IntentInterface;

class UpdateBudgetIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'UpdateBudgetIntent',
            'message' => 'Intent UpdateBudgetIntent executed successfully. Validating Dispatcher...'
        ];
    }
}