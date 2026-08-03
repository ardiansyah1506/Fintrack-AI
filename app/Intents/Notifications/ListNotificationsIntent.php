<?php

namespace App\Intents\Notifications;

use App\Intents\IntentInterface;

class ListNotificationsIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'list_notifications', 
            'status' => 'success',
            'intent' => 'ListNotificationsIntent',
            'message' => 'Intent ListNotificationsIntent executed successfully. Validating Dispatcher...'
        ];
    }
}