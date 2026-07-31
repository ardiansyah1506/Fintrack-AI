<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AiAchievementRequest;
use App\Services\AiAchievementService;
use App\Http\Resources\AiAchievementResource;
class AiAchievementController extends Controller {
    public function __construct(protected AiAchievementService $service) {}
    public function index(Request $request) { return AiAchievementResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(AiAchievementRequest $request) { return new AiAchievementResource($this->service->create($request->validated())); }
    public function show($id) { return new AiAchievementResource(app(\App\Contracts\Repositories\AiAchievementRepositoryInterface::class)->find($id)); }
    public function update(AiAchievementRequest $request, $id) { return new AiAchievementResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}