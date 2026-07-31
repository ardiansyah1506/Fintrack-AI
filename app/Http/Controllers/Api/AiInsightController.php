<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiInsightRequest;
use App\Services\AiInsightService;
use App\Http\Resources\AiInsightResource;
class AiInsightController extends Controller {
    public function __construct(protected AiInsightService $service) {}
    public function index(Request $request) { return AiInsightResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiInsightRequest $request) { return new AiInsightResource($this->service->create($request->validated())); }
    public function show($id) { return new AiInsightResource(app(\App\Contracts\Repositories\AiInsightRepositoryInterface::class)->find($id)); }
    public function update(AiInsightRequest $request, $id) { return new AiInsightResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}