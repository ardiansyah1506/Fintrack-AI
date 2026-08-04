<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiRecommendationRequest;
use App\Http\Resources\AiRecommendationResource;
use App\Services\AiRecommendationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiRecommendationController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiRecommendationService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiRecommendationResource::collection($data),
            'Berhasil mengambil data rekomendasi',
            200,
            'list_ai_recommendations',
            'ai_recommendation'
        );
    }

    public function store(AiRecommendationRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiRecommendationResource($data),
            'AI Recommendation berhasil dibuat',
            201,
            'create_ai_recommendation',
            'ai_recommendation'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiRecommendationRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiRecommendationResource($data),
            'Berhasil mengambil detail rekomendasi',
            200,
            'get_ai_recommendation',
            'ai_recommendation'
        );
    }

    public function update(AiRecommendationRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiRecommendationResource($data),
            'AI Recommendation berhasil diperbarui',
            200,
            'update_ai_recommendation',
            'ai_recommendation'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Recommendation berhasil dihapus', 200, 'delete_ai_recommendation', 'ai_recommendation');
    }
}