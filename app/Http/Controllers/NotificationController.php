<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $service;
    public function __construct(NotificationService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return view('notifications.index', [
            'notifications' => $this->service->getAll($filters, 10)
        ]);
    }

    public function store(NotificationRequest $request) {
        $this->service->create($request->validated());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(NotificationRequest $request, $id) {
        $this->service->update($id, $request->validated());
        return back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}