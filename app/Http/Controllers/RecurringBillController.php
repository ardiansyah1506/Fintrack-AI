<?php
namespace App\Http\Controllers;

use App\Models\RecurringBill;
use Illuminate\Http\Request;

class RecurringBillController extends Controller
{
    protected $service;
    public function __construct(\App\Services\RecurringBillService $service) {
        $this->service = $service;
    }

    public function index()
    {
        return view('bills.index', [
            'bills' => $this->service->getAll()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['auto_create_transaction'] = $request->has('auto_create_transaction');
        $this->service->create($data);
        return back()->with('success', 'Tagihan rutin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['auto_create_transaction'] = $request->has('auto_create_transaction');
        $this->service->update($id, $data);
        return back()->with('success', 'Tagihan rutin berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Tagihan rutin berhasil dihapus.');
    }
}
