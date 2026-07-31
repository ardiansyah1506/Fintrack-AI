<?php

namespace App\Intents\Reminders;

use App\Intents\IntentInterface;

class DeleteReminderIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'DeleteReminderIntent',
            'message' => 'Intent DeleteReminderIntent executed successfully. Validating Dispatcher...'
        ];
    }
}