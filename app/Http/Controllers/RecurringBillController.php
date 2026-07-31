<?php
namespace App\Http\Controllers;

use App\Models\RecurringBill;
use Illuminate\Http\Request;

class RecurringBillController extends Controller
{
    public function index()
    {
        return view('bills.index', [
            'bills' => RecurringBill::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['auto_create_transaction'] = $request->has('auto_create_transaction');
        RecurringBill::create($data);
        return back()->with('success', 'Tagihan rutin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['auto_create_transaction'] = $request->has('auto_create_transaction');
        RecurringBill::findOrFail($id)->update($data);
        return back()->with('success', 'Tagihan rutin berhasil diupdate.');
    }

    public function destroy($id)
    {
        RecurringBill::findOrFail($id)->delete();
        return back()->with('success', 'Tagihan rutin berhasil dihapus.');
    }
}
