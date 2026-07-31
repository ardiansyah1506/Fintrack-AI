<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiInsightRequest;
use App\Services\AiInsightService;
class AiInsightController extends Controller {
    public function __construct(protected AiInsightService $service) {}
    public function index(Request $request) {
        return view('ai-insights.index', ['ai_insights' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiInsightRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiInsightRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}