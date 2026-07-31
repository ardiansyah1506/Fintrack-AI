<?php
namespace App\Intents\SavingGoals;
use App\Intents\Contracts\IntentInterface;
use App\Services\SavingGoalService;
class CreateSavingGoalIntent implements IntentInterface {
    public function __construct(protected SavingGoalService $service) {}
    public function handle(array $params): array {
        $res = $this->service->create($params);
        return ['intent' => 'create_saving_goal', 'status' => 'success', 'message' => 'Target tabungan berhasil dibuat', 'saving_goal' => $res];
    }
}