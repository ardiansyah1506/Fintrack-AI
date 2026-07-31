<?php

namespace App\Services;

class BotExecutionService
{
    public function __construct(
        protected IntentDispatcherService $dispatcher
    ) {}

    /**
     * Entry point for executing an intent from Telegram Bot webhook
     */
    public function execute(string $intent, array $parameters = []): array
    {
        // Any pre-dispatch logic (logging request to ai_logs, chat_history etc) can go here
        
        // Log to Chat History (stub, best put inside repository event or directly here)
        // ChatHistory::create([ ... ])

        try {
            $result = $this->dispatcher->dispatch($intent, $parameters);
            
            // Log success to AiLogs (stub)
            return [
                'success' => true,
                'intent' => $intent,
                'data' => $result
            ];
        } catch (\InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Kesalahan sistem saat memroses intent: ' . $th->getMessage()
            ];
        }
    }
}
