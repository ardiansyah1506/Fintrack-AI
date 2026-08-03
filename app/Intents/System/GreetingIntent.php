<?php

namespace App\Intents\System;

use App\Intents\Contracts\IntentInterface;

class GreetingIntent implements IntentInterface
{
    public function handle(array $parameters): array
    {
        return ['intent' => 'greeting', 
            'status' => 'success',
            'message' => 'Halo! Saya FinTrack AI Assistant. Ada yang bisa saya bantu mengelola keuangan Anda hari ini?',
            'data' => [
                'bot_name' => 'FinTrack AI',
                'status' => 'online'
            ]
        ];
    }
}
