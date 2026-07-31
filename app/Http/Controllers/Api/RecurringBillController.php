<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecurringBillService;

class RecurringBillController extends Controller
{
    protected $service;

    public function __construct(RecurringBillService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(['data' => $this->service->getUpcomingBills()]);
    }
}
