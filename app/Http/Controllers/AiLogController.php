<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiLogRequest;
use App\Services\AiLogService;
class AiLogController extends Controller {
    public function __construct(protected AiLogService $service) {}
    public function index(Request $request) {
        return view('ai-logs.index', ['ai_logs' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiLogRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiLogRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}