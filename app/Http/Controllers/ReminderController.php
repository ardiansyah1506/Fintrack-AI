<?php
namespace App\Http\Controllers;

use App\Services\ReminderService;

class ReminderController extends Controller
{
    public function __construct(protected ReminderService $service) {}

    public function index()
    {
        return view('reminders.index', [
            'reminders' => \App\Models\Reminder::latest()->get()
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        \App\Models\Reminder::create($request->all());
        return back()->with('success', 'Reminder berhasil ditambahkan.');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        \App\Models\Reminder::findOrFail($id)->update($request->all());
        return back()->with('success', 'Reminder berhasil diupdate.');
    }

    public function destroy($id)
    {
        \App\Models\Reminder::findOrFail($id)->delete();
        return back()->with('success', 'Reminder berhasil dihapus.');
    }
}
