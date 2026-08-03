<?php

namespace App\Intents\SavingGoals;

use App\Intents\IntentInterface;

class DeleteSavingGoalIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'delete_saving_goal', 
            'status' => 'success',
            'intent' => 'DeleteSavingGoalIntent',
            'message' => 'Intent DeleteSavingGoalIntent executed successfully. Validating Dispatcher...'
        ];
    }
}