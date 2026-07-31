<?php

namespace App\Intents\Notifications;

use App\Intents\IntentInterface;

class ListNotificationsIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ListNotificationsIntent',
            'message' => 'Intent ListNotificationsIntent executed successfully. Validating Dispatcher...'
        ];
    }
}