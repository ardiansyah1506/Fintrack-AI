<?php

namespace App\Intents\Budgets;

use App\Intents\IntentInterface;

class DeleteBudgetIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'DeleteBudgetIntent',
            'message' => 'Intent DeleteBudgetIntent executed successfully. Validating Dispatcher...'
        ];
    }
}