<?php
namespace App\Http\Controllers;

use App\Models\SavingGoal;
use Illuminate\Http\Request;

class SavingGoalController extends Controller
{
    public function index()
    {
        return view('saving-goals.index', [
            'goals' => SavingGoal::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        SavingGoal::create($request->all());
        return back()->with('success', 'Saving Goal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        SavingGoal::findOrFail($id)->update($request->all());
        return back()->with('success', 'Saving Goal berhasil diupdate.');
    }

    public function destroy($id)
    {
        SavingGoal::findOrFail($id)->delete();
        return back()->with('success', 'Saving Goal berhasil dihapus.');
    }
}
