<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiLogRequest;
use App\Http\Resources\AiLogResource;
use App\Services\AiLogService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiLogController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiLogService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiLogResource::collection($data),
            'Berhasil mengambil data log AI',
            200,
            'list_ai_logs',
            'ai_log'
        );
    }

    public function store(AiLogRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiLogResource($data),
            'AI Log berhasil dibuat',
            201,
            'create_ai_log',
            'ai_log'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiLogRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiLogResource($data),
            'Berhasil mengambil detail log AI',
            200,
            'get_ai_log',
            'ai_log'
        );
    }

    public function update(AiLogRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiLogResource($data),
            'AI Log berhasil diperbarui',
            200,
            'update_ai_log',
            'ai_log'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Log berhasil dihapus', 200, 'delete_ai_log', 'ai_log');
    }
}