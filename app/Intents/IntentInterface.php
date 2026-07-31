<?php

namespace App\Intents;

interface IntentInterface
{
    /**
     * Execute the intent logic and return the result array.
     *
     * @param array $parameters
     * @return array
     */
    public function handle(array $parameters): array;
}
