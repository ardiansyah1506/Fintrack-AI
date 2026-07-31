<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiPredictionRequest;
use App\Services\AiPredictionService;
use App\Http\Resources\AiPredictionResource;
class AiPredictionController extends Controller {
    public function __construct(protected AiPredictionService $service) {}
    public function index(Request $request) { return AiPredictionResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiPredictionRequest $request) { return new AiPredictionResource($this->service->create($request->validated())); }
    public function show($id) { return new AiPredictionResource(app(\App\Contracts\Repositories\AiPredictionRepositoryInterface::class)->find($id)); }
    public function update(AiPredictionRequest $request, $id) { return new AiPredictionResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}