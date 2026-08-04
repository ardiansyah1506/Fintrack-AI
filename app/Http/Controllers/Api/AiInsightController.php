<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiInsightRequest;
use App\Http\Resources\AiInsightResource;
use App\Services\AiInsightService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiInsightController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiInsightService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiInsightResource::collection($data),
            'Berhasil mengambil data insight',
            200,
            'list_ai_insights',
            'ai_insight'
        );
    }

    public function store(AiInsightRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiInsightResource($data),
            'AI Insight berhasil dibuat',
            201,
            'create_ai_insight',
            'ai_insight'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiInsightRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiInsightResource($data),
            'Berhasil mengambil detail insight',
            200,
            'get_ai_insight',
            'ai_insight'
        );
    }

    public function update(AiInsightRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiInsightResource($data),
            'AI Insight berhasil diperbarui',
            200,
            'update_ai_insight',
            'ai_insight'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Insight berhasil dihapus', 200, 'delete_ai_insight', 'ai_insight');
    }
}