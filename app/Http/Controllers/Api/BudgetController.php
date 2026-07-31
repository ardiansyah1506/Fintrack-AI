<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BudgetService;

class BudgetController extends Controller
{
    protected $service;

    public function __construct(BudgetService $service)
    {
        $this->service = $service;
    }

    public function summary()
    {
        return response()->json(['data' => $this->service->getBudgetSummary()]);
    }
}
