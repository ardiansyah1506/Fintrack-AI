<?php

namespace App\Intents\Memories;

use App\Intents\IntentInterface;

class DeleteMemoryIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'DeleteMemoryIntent',
            'message' => 'Intent DeleteMemoryIntent executed successfully. Validating Dispatcher...'
        ];
    }
}