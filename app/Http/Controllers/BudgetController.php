<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    protected $service;
    public function __construct(\App\Services\BudgetService $service) {
        $this->service = $service;
    }

    public function index()
    {
        return view('budgets.index', [
            'budgets' => $this->service->getAll()
        ]);
    }

    public function store(Request $request)
    {
        $this->service->create($request->all());
        return back()->with('success', 'Budget berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());
        return back()->with('success', 'Budget berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Budget berhasil dihapus.');
    }
}
