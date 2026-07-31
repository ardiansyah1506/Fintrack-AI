<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\SavingGoalRequest;
use App\Services\SavingGoalService;

class SavingGoalController extends Controller
{
    protected $service;
    public function __construct(SavingGoalService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return view('saving-goals.index', [
            'saving_goals' => $this->service->getAll($filters, 10)
        ]);
    }

    public function store(SavingGoalRequest $request) {
        $this->service->create($request->validated());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(SavingGoalRequest $request, $id) {
        $this->service->update($id, $request->validated());
        return back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}