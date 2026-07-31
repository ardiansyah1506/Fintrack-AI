<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SavingGoalRequest;
use App\Services\SavingGoalService;
use App\Http\Resources\SavingGoalResource;

class SavingGoalController extends Controller
{
    protected $service;
    public function __construct(SavingGoalService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return SavingGoalResource::collection($this->service->getAll($filters, 10));
    }

    public function store(SavingGoalRequest $request) {
        $data = $this->service->create($request->validated());
        return new SavingGoalResource($data);
    }

    public function show($id) {
        return new SavingGoalResource($this->service->repository->find($id));
    }

    public function update(SavingGoalRequest $request, $id) {
        $data = $this->service->update($id, $request->validated());
        return new SavingGoalResource($data);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted completely']);
    }
}