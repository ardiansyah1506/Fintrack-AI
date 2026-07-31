<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ReminderRequest;
use App\Services\ReminderService;

class ReminderController extends Controller
{
    protected $service;
    public function __construct(ReminderService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return view('reminders.index', [
            'reminders' => $this->service->getAll($filters, 10)
        ]);
    }

    public function store(ReminderRequest $request) {
        $this->service->create($request->validated());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(ReminderRequest $request, $id) {
        $this->service->update($id, $request->validated());
        return back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}