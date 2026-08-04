<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavingGoalRequest;
use App\Http\Resources\SavingGoalResource;
use App\Services\SavingGoalService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SavingGoalController extends Controller
{
    use ApiResponse;

    public function __construct(protected SavingGoalService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $data = $this->service->getAll($filters, 10);

        return $this->successResponse(
            SavingGoalResource::collection($data),
            'Berhasil mengambil data tabungan',
            200,
            'list_saving_goals',
            'saving_goals'
        );
    }

    public function store(SavingGoalRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new SavingGoalResource($data),
            'Target tabungan berhasil dibuat',
            201,
            'create_saving_goal',
            'saving_goal'
        );
    }

    public function show($id)
    {
        $data = $this->service->repository->find($id);

        return $this->successResponse(
            new SavingGoalResource($data),
            'Berhasil mengambil detail tabungan',
            200,
            'get_saving_goal',
            'saving_goal'
        );
    }

    public function update(SavingGoalRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new SavingGoalResource($data),
            'Target tabungan berhasil diperbarui',
            200,
            'update_saving_goal',
            'saving_goal'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(
            null,
            'Target tabungan berhasil dihapus',
            200,
            'delete_saving_goal',
            'saving_goal'
        );
    }
}