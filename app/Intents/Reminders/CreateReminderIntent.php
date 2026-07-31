<?php

namespace App\Intents\Reminders;

use App\Intents\IntentInterface;

class CreateReminderIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'CreateReminderIntent',
            'message' => 'Intent CreateReminderIntent executed successfully. Validating Dispatcher...'
        ];
    }
}