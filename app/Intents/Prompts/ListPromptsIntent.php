<?php

namespace App\Intents\Prompts;

use App\Intents\IntentInterface;

class ListPromptsIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ListPromptsIntent',
            'message' => 'Intent ListPromptsIntent executed successfully. Validating Dispatcher...'
        ];
    }
}