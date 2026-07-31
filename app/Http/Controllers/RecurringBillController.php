<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\RecurringBillRequest;
use App\Services\RecurringBillService;

class RecurringBillController extends Controller
{
    protected $service;
    public function __construct(RecurringBillService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return view('bills.index', [
            'bills' => $this->service->getAll($filters, 10)
        ]);
    }

    public function store(RecurringBillRequest $request) {
        $this->service->create($request->validated());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(RecurringBillRequest $request, $id) {
        $this->service->update($id, $request->validated());
        return back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}