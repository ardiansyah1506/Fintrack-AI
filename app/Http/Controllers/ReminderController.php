<?php
namespace App\Http\Controllers;

use App\Services\ReminderService;

class ReminderController extends Controller
{
    public function __construct(protected ReminderService $service) {}

    public function index()
    {
        return view('reminders.index', [
            'reminders' => $this->service->getAll()
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $this->service->create($request->all());
        return back()->with('success', 'Reminder berhasil ditambahkan.');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $this->service->update($id, $request->all());
        return back()->with('success', 'Reminder berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Reminder berhasil dihapus.');
    }
}
