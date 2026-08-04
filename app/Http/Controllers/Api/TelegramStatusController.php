<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class TelegramStatusController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse([
            'bot_status'        => 'online',
            'last_sync'         => now()->subMinutes(5)->toDateTimeString(),
            'last_message'      => 'Tolong catat pengeluaran makan 50k',
            'webhook_status'    => 'active',
            'workflow_status'   => 'listening',
            'connection_status' => 'connected',
        ], 'Status Telegram berhasil diambil', 200, 'telegram_status', 'telegram');
    }
}
