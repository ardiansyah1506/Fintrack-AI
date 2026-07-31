<?php

namespace App\Intents\Contracts;

interface IntentInterface
{
    public function handle(array $parameters): array;
}
