<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiMemoryRequest;
use App\Services\AiMemoryService;
use App\Http\Resources\AiMemoryResource;
class AiMemoryController extends Controller {
    public function __construct(protected AiMemoryService $service) {}
    public function index(Request $request) { return AiMemoryResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiMemoryRequest $request) { return new AiMemoryResource($this->service->create($request->validated())); }
    public function show($id) { return new AiMemoryResource(app(\App\Contracts\Repositories\AiMemoryRepositoryInterface::class)->find($id)); }
    public function update(AiMemoryRequest $request, $id) { return new AiMemoryResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}