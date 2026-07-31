<?php

namespace App\Intents\System;

use App\Intents\IntentInterface;

class TelegramStatusIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'TelegramStatusIntent',
            'message' => 'Intent TelegramStatusIntent executed successfully. Validating Dispatcher...'
        ];
    }
}