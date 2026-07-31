<?php
namespace App\Http\Controllers;

use App\Services\AiInsightService;

class AiInsightController extends Controller
{
    public function __construct(protected AiInsightService $service) {}

    public function index()
    {
        return view('ai-insights.index', [
            'insights' => $this->service->getAllInsights()
        ]);
    }
}
