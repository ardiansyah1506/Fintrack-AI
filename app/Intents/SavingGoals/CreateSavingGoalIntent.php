<?php

namespace App\Intents\SavingGoals;

use App\Intents\IntentInterface;

class CreateSavingGoalIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'CreateSavingGoalIntent',
            'message' => 'Intent CreateSavingGoalIntent executed successfully. Validating Dispatcher...'
        ];
    }
}