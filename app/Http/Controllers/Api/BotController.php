<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BotService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class BotController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected BotService $botService
    ) {}

    /**
     * POST /api/bot/execute
     * Primary n8n / Telegram Bot webhook intent processor.
     */
    public function execute(Request $request)
    {
        $input = $request->all();

        // If n8n sends payload wrapped in an array [ { "intent": "..." } ]
        if (isset($input[0]) && is_array($input[0])) {
            $input = $input[0];
        }

        $validator = validator($input, [
            'intent' => 'required|string',
            'parameters' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(
                'Format payload tidak valid',
                $validator->errors(),
                422
            );
        }

        $validated = $validator->validated();
        $intent = $validated['intent'];
        $parameters = $validated['parameters'] ?? [];

        try {
            $result = $this->botService->executeIntent($intent, $parameters);

            return $this->successResponse(
                $result,
                "Intent '{$intent}' berhasil diproses."
            );
        } catch (Throwable $e) {
            return $this->errorResponse(
                $e->getMessage(),
                ['intent' => $intent],
                400
            );
        }
    }
}
