<?php

namespace App\Services;

class BotService
{
    public function __construct(
        protected IntentDispatcherService $dispatcher
    ) {}

    /**
     * Execute bot intent payload from n8n / Telegram Bot.
     */
    public function executeIntent(string $intent, array $parameters = []): array
    {
        // Pass intent directly to IntentDispatcherService
        return $this->dispatcher->dispatch($intent, $parameters);
    }
}
