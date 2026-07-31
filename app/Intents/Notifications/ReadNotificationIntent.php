<?php

namespace App\Intents\Notifications;

use App\Intents\IntentInterface;

class ReadNotificationIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ReadNotificationIntent',
            'message' => 'Intent ReadNotificationIntent executed successfully. Validating Dispatcher...'
        ];
    }
}