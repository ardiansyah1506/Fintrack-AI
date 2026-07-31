<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\BudgetRequest;
use App\Services\BudgetService;

class BudgetController extends Controller
{
    protected $service;
    public function __construct(BudgetService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return view('budgets.index', [
            'budgets' => $this->service->getAll($filters, 10)
        ]);
    }

    public function store(BudgetRequest $request) {
        $this->service->create($request->validated());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(BudgetRequest $request, $id) {
        $this->service->update($id, $request->validated());
        return back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}