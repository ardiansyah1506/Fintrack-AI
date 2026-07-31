<?php

namespace App\Intents\System;

use App\Intents\IntentInterface;

class HelpIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'HelpIntent',
            'message' => 'Intent HelpIntent executed successfully. Validating Dispatcher...'
        ];
    }
}