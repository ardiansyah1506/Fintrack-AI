<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiLogRequest;
use App\Services\AiLogService;
use App\Http\Resources\AiLogResource;
class AiLogController extends Controller {
    public function __construct(protected AiLogService $service) {}
    public function index(Request $request) { return AiLogResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiLogRequest $request) { return new AiLogResource($this->service->create($request->validated())); }
    public function show($id) { return new AiLogResource(app(\App\Contracts\Repositories\AiLogRepositoryInterface::class)->find($id)); }
    public function update(AiLogRequest $request, $id) { return new AiLogResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}