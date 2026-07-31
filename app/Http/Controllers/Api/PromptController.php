<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PromptRequest;
use App\Services\PromptService;
use App\Http\Resources\PromptResource;
class PromptController extends Controller {
    public function __construct(protected PromptService $service) {}
    public function index(Request $request) { return PromptResource::collection($this->service->getAll($request->only('search'), 10)); }
    public function store(PromptRequest $request) { return new PromptResource($this->service->create($request->validated())); }
    public function show($id) { return new PromptResource(app(\App\Contracts\Repositories\PromptRepositoryInterface::class)->find($id)); }
    public function update(PromptRequest $request, $id) { return new PromptResource($this->service->update($id, $request->validated())); }
    public function destroy($id) { $this->service->delete($id); return response()->json(['message' => 'Deleted']); }
}