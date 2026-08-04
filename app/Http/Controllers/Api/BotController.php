<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BotExecutionService;
use App\Traits\ApiResponse;

class BotController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected BotExecutionService $botExecutionService
    ) {}

    /**
     * Unified Hook Endpoint
     * Method   : POST
     * Endpoint : /api/bot/execute
     * Format   : JSON
     */
    public function execute(Request $request)
    {
        try {
            $validated = $request->validate([
                'intent'     => 'required|string',
                'parameters' => 'nullable|array',
            ]);

            $intentName = $validated['intent'] ?? 'unknown';
            $parameters = $validated['parameters'] ?? [];

            $executionResult = $this->botExecutionService->execute($intentName, $parameters);

            if (isset($executionResult['success']) && $executionResult['success'] === false) {
                return $this->errorResponse(
                    $executionResult['message'] ?? 'Failed executing intent',
                    400,
                    null,
                    $intentName,
                    $executionResult['resource'] ?? ''
                );
            }

            return $this->successResponse(
                $executionResult['data'] ?? [],
                $executionResult['message'] ?? 'Intent berhasil dieksekusi',
                200,
                $intentName,
                $executionResult['resource'] ?? ''
            );

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return $this->errorResponse('Validasi gagal', 422, $ve->errors(), 'unknown', '');
        } catch (\Throwable $th) {
            return $this->errorResponse('Terjadi kesalahan pada Controller API: ' . $th->getMessage(), 500, null, 'unknown', '');
        }
    }
}

