<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReminderRequest;
use App\Services\ReminderService;
use App\Http\Resources\ReminderResource;

class ReminderController extends Controller
{
    protected $service;
    public function __construct(ReminderService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return ReminderResource::collection($this->service->getAll($filters, 10));
    }

    public function store(ReminderRequest $request) {
        $data = $this->service->create($request->validated());
        return new ReminderResource($data);
    }

    public function show($id) {
        return new ReminderResource($this->service->repository->find($id));
    }

    public function update(ReminderRequest $request, $id) {
        $data = $this->service->update($id, $request->validated());
        return new ReminderResource($data);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted completely']);
    }
}