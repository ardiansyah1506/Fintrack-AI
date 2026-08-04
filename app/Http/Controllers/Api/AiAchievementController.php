<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiAchievementRequest;
use App\Http\Resources\AiAchievementResource;
use App\Services\AiAchievementService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AiAchievementController extends Controller
{
    use ApiResponse;

    public function __construct(protected AiAchievementService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            AiAchievementResource::collection($data),
            'Berhasil mengambil data achievement',
            200,
            'list_ai_achievements',
            'ai_achievement'
        );
    }

    public function store(AiAchievementRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new AiAchievementResource($data),
            'AI Achievement berhasil dibuat',
            201,
            'create_ai_achievement',
            'ai_achievement'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\AiAchievementRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new AiAchievementResource($data),
            'Berhasil mengambil detail achievement',
            200,
            'get_ai_achievement',
            'ai_achievement'
        );
    }

    public function update(AiAchievementRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new AiAchievementResource($data),
            'AI Achievement berhasil diperbarui',
            200,
            'update_ai_achievement',
            'ai_achievement'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'AI Achievement berhasil dihapus', 200, 'delete_ai_achievement', 'ai_achievement');
    }
}