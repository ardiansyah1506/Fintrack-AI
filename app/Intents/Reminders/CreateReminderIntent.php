<?php
namespace App\Intents\Reminders;
use App\Intents\Contracts\IntentInterface;
use App\Services\ReminderService;
class CreateReminderIntent implements IntentInterface {
    public function __construct(protected ReminderService $service) {}
    public function handle(array $params): array {
        $res = $this->service->create($params);
        return ['intent' => 'create_reminder', 'status' => 'success', 'message' => 'Pengingat berhasil dibuat', 'reminder' => $res];
    }
}