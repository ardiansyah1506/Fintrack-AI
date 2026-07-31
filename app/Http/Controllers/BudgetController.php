<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        return view('budgets.index', [
            'budgets' => Budget::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        Budget::create($request->all());
        return back()->with('success', 'Budget berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        Budget::findOrFail($id)->update($request->all());
        return back()->with('success', 'Budget berhasil diupdate.');
    }

    public function destroy($id)
    {
        Budget::findOrFail($id)->delete();
        return back()->with('success', 'Budget berhasil dihapus.');
    }
}
