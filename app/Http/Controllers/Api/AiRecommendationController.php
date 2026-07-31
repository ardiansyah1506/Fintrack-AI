<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiRecommendationRequest;
use App\Services\AiRecommendationService;
use App\Http\Resources\AiRecommendationResource;
class AiRecommendationController extends Controller {
    public function __construct(protected AiRecommendationService $service) {}
    public function index(Request $request) { return AiRecommendationResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiRecommendationRequest $request) { return new AiRecommendationResource($this->service->create($request->validated())); }
    public function show($id) { return new AiRecommendationResource(app(\App\Contracts\Repositories\AiRecommendationRepositoryInterface::class)->find($id)); }
    public function update(AiRecommendationRequest $request, $id) { return new AiRecommendationResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}