<?php
namespace App\Http\Controllers;

use App\Services\BudgetService;

class BudgetController extends Controller
{
    public function __construct(protected BudgetService $service) {}

    public function index()
    {
        return view('budgets.index', [
            'budgets' => $this->service->getBudgetSummary()
        ]);
    }
}
