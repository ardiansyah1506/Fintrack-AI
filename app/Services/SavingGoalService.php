<?php

namespace App\Services;

use App\Models\SavingGoal;
use Illuminate\Database\Eloquent\Collection;

class SavingGoalService
{
    public function getAllGoals(): Collection
    {
        return SavingGoal::all();
    }

    public function createGoal(array $data): SavingGoal
    {
        return SavingGoal::create($data);
    }

    public function updateGoal($id, array $data): SavingGoal
    {
        $goal = SavingGoal::findOrFail($id);
        $goal->update($data);
        return $goal;
    }

    public function deleteGoal($id): void
    {
        $goal = SavingGoal::findOrFail($id);
        $goal->delete();
    }
}
