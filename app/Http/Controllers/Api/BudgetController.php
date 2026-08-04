<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Services\BudgetService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    use ApiResponse;

    public function __construct(protected BudgetService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $data = $this->service->getAll($filters, 10);

        return $this->successResponse(
            BudgetResource::collection($data),
            'Berhasil mengambil data budget',
            200,
            'list_budgets',
            'budgets'
        );
    }

    public function store(BudgetRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new BudgetResource($data),
            'Budget berhasil dibuat',
            201,
            'create_budget',
            'budget'
        );
    }

    public function show($id)
    {
        $data = $this->service->repository->find($id);

        return $this->successResponse(
            new BudgetResource($data),
            'Berhasil mengambil detail budget',
            200,
            'get_budget',
            'budget'
        );
    }

    public function update(BudgetRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new BudgetResource($data),
            'Budget berhasil diperbarui',
            200,
            'update_budget',
            'budget'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(
            null,
            'Budget berhasil dihapus',
            200,
            'delete_budget',
            'budget'
        );
    }
}