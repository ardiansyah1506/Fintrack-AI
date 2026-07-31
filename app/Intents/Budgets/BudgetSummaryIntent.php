<?php

namespace App\Intents\Budgets;

use App\Intents\IntentInterface;

class BudgetSummaryIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'BudgetSummaryIntent',
            'message' => 'Intent BudgetSummaryIntent executed successfully. Validating Dispatcher...'
        ];
    }
}