<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RecurringBillRequest;
use App\Services\RecurringBillService;
use App\Http\Resources\RecurringBillResource;

class RecurringBillController extends Controller
{
    protected $service;
    public function __construct(RecurringBillService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return RecurringBillResource::collection($this->service->getAll($filters, 10));
    }

    public function store(RecurringBillRequest $request) {
        $data = $this->service->create($request->validated());
        return new RecurringBillResource($data);
    }

    public function show($id) {
        return new RecurringBillResource($this->service->repository->find($id));
    }

    public function update(RecurringBillRequest $request, $id) {
        $data = $this->service->update($id, $request->validated());
        return new RecurringBillResource($data);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted completely']);
    }
}