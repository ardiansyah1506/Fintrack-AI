<?php

namespace App\Intents\Memories;

use App\Intents\IntentInterface;

class ListMemoriesIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'list_memories', 
            'status' => 'success',
            'intent' => 'ListMemoriesIntent',
            'message' => 'Intent ListMemoriesIntent executed successfully. Validating Dispatcher...'
        ];
    }
}