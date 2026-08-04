<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiMemoryRequest;
use App\Http\Resources\AiMemoryResource;
use App\Services\AiMemoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiMemoryController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiMemoryService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiMemoryResource::collection($data),
            'Berhasil mengambil data memori AI',
            200,
            'list_ai_memories',
            'ai_memory'
        );
    }

    public function store(AiMemoryRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiMemoryResource($data),
            'AI Memory berhasil dibuat',
            201,
            'create_ai_memory',
            'ai_memory'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiMemoryRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiMemoryResource($data),
            'Berhasil mengambil detail memori AI',
            200,
            'get_ai_memory',
            'ai_memory'
        );
    }

    public function update(AiMemoryRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiMemoryResource($data),
            'AI Memory berhasil diperbarui',
            200,
            'update_ai_memory',
            'ai_memory'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Memory berhasil dihapus', 200, 'delete_ai_memory', 'ai_memory');
    }
}