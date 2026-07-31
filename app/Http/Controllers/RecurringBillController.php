<?php
namespace App\Http\Controllers;

use App\Services\RecurringBillService;

class RecurringBillController extends Controller
{
    public function __construct(protected RecurringBillService $service) {}

    public function index()
    {
        return view('bills.index', [
            'bills' => $this->service->getAllBills()
        ]);
    }
}
