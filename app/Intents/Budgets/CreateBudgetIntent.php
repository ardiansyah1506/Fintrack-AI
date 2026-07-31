<?php
namespace App\Intents\Budgets;
use App\Intents\Contracts\IntentInterface;
use App\Services\BudgetService;
class CreateBudgetIntent implements IntentInterface {
    public function __construct(protected BudgetService $service) {}
    public function handle(array $params): array {
        $res = $this->service->create($params);
        return ['intent' => 'create_budget', 'status' => 'success', 'message' => 'Budget berhasil dibuat', 'budget' => $res];
    }
}