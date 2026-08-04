<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiWarningRequest;
use App\Http\Resources\AiWarningResource;
use App\Services\AiWarningService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiWarningController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiWarningService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiWarningResource::collection($data),
            'Berhasil mengambil data peringatan',
            200,
            'list_ai_warnings',
            'ai_warning'
        );
    }

    public function store(AiWarningRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiWarningResource($data),
            'AI Warning berhasil dibuat',
            201,
            'create_ai_warning',
            'ai_warning'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiWarningRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiWarningResource($data),
            'Berhasil mengambil detail peringatan',
            200,
            'get_ai_warning',
            'ai_warning'
        );
    }

    public function update(AiWarningRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiWarningResource($data),
            'AI Warning berhasil diperbarui',
            200,
            'update_ai_warning',
            'ai_warning'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Warning berhasil dihapus', 200, 'delete_ai_warning', 'ai_warning');
    }
}