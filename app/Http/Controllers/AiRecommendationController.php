<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiRecommendationRequest;
use App\Services\AiRecommendationService;
class AiRecommendationController extends Controller {
    public function __construct(protected AiRecommendationService $service) {}
    public function index(Request $request) {
        return view('recommendations.index', ['recommendations' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiRecommendationRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiRecommendationRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}