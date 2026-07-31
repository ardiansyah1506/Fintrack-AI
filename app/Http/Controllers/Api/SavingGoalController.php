<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SavingGoalService;

class SavingGoalController extends Controller
{
    protected $service;

    public function __construct(SavingGoalService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(['data' => $this->service->getAllGoals()]);
    }
}
