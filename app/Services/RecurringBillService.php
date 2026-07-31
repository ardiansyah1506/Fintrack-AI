<?php

namespace App\Services;

use App\Models\RecurringBill;
use Illuminate\Database\Eloquent\Collection;

class RecurringBillService
{
    public function getAllBills(): Collection
    {
        return RecurringBill::orderBy('billing_date', 'asc')->get();
    }

    public function getUpcomingBills(): Collection
    {
        return RecurringBill::where('status', 'active')
            ->orderBy('billing_date', 'asc')
            ->get();
    }

    public function createBill(array $data): RecurringBill
    {
        return RecurringBill::create($data);
    }

    public function updateBill($id, array $data): RecurringBill
    {
        $bill = RecurringBill::findOrFail($id);
        $bill->update($data);
        return $bill;
    }

    public function deleteBill($id): void
    {
        $bill = RecurringBill::findOrFail($id);
        $bill->delete();
    }
}
