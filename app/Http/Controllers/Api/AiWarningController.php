<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiWarningRequest;
use App\Services\AiWarningService;
use App\Http\Resources\AiWarningResource;
class AiWarningController extends Controller {
    public function __construct(protected AiWarningService $service) {}
    public function index(Request $request) { return AiWarningResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiWarningRequest $request) { return new AiWarningResource($this->service->create($request->validated())); }
    public function show($id) { return new AiWarningResource(app(\App\Contracts\Repositories\AiWarningRepositoryInterface::class)->find($id)); }
    public function update(AiWarningRequest $request, $id) { return new AiWarningResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}