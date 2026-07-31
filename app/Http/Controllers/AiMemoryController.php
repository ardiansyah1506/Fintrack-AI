<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiMemoryRequest;
use App\Services\AiMemoryService;
class AiMemoryController extends Controller {
    public function __construct(protected AiMemoryService $service) {}
    public function index(Request $request) {
        return view('memories.index', ['memories' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiMemoryRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiMemoryRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}