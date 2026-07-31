<?php

namespace App\Intents\Statistics;

use App\Intents\IntentInterface;

class ReportIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return [
            'status' => 'success',
            'intent' => 'ReportIntent',
            'message' => 'Intent ReportIntent executed successfully. Validating Dispatcher...'
        ];
    }
}