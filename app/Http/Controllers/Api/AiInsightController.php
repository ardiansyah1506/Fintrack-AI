<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AiInsightService;

class AiInsightController extends Controller
{
    protected $service;

    public function __construct(AiInsightService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(['data' => $this->service->getAllInsights()]);
    }
}
