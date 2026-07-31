<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TelegramStatusController extends Controller
{
    public function index()
    {
        return response()->json([
            'bot_status' => 'online',
            'last_sync' => now()->subMinutes(5)->toDateTimeString(),
            'last_message' => 'Tolong catat pengeluaran makan 50k',
            'webhook_status' => 'active',
            'workflow_status' => 'listening',
            'connection_status' => 'connected'
        ]);
    }
}
