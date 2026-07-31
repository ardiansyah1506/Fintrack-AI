<?php

namespace App\Intents\Reminders;

use App\Intents\IntentInterface;

class ListRemindersIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ListRemindersIntent',
            'message' => 'Intent ListRemindersIntent executed successfully. Validating Dispatcher...'
        ];
    }
}