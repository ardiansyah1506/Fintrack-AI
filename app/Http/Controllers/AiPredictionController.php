<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiPredictionRequest;
use App\Services\AiPredictionService;
class AiPredictionController extends Controller {
    public function __construct(protected AiPredictionService $service) {}
    public function index(Request $request) {
        return view('predictions.index', ['predictions' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiPredictionRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiPredictionRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}