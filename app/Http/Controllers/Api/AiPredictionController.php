<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiPredictionRequest;
use App\Http\Resources\AiPredictionResource;
use App\Services\AiPredictionService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiPredictionController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiPredictionService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiPredictionResource::collection($data),
            'Berhasil mengambil data prediksi',
            200,
            'list_ai_predictions',
            'ai_prediction'
        );
    }

    public function store(AiPredictionRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiPredictionResource($data),
            'AI Prediction berhasil dibuat',
            201,
            'create_ai_prediction',
            'ai_prediction'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiPredictionRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiPredictionResource($data),
            'Berhasil mengambil detail prediksi',
            200,
            'get_ai_prediction',
            'ai_prediction'
        );
    }

    public function update(AiPredictionRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiPredictionResource($data),
            'AI Prediction berhasil diperbarui',
            200,
            'update_ai_prediction',
            'ai_prediction'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Prediction berhasil dihapus', 200, 'delete_ai_prediction', 'ai_prediction');
    }
}