<?php
namespace App\Http\Controllers;

use App\Services\SavingGoalService;

class SavingGoalController extends Controller
{
    public function __construct(protected SavingGoalService $service) {}

    public function index()
    {
        return view('saving-goals.index', [
            'goals' => $this->service->getAllGoals()
        ]);
    }
}
