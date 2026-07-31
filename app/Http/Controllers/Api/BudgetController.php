<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BudgetRequest;
use App\Services\BudgetService;
use App\Http\Resources\BudgetResource;

class BudgetController extends Controller
{
    protected $service;
    public function __construct(BudgetService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return BudgetResource::collection($this->service->getAll($filters, 10));
    }

    public function store(BudgetRequest $request) {
        $data = $this->service->create($request->validated());
        return new BudgetResource($data);
    }

    public function show($id) {
        return new BudgetResource($this->service->repository->find($id));
    }

    public function update(BudgetRequest $request, $id) {
        $data = $this->service->update($id, $request->validated());
        return new BudgetResource($data);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted completely']);
    }
}