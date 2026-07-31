<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Services\NotificationService;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    protected $service;
    public function __construct(NotificationService $service) { $this->service = $service; }

    public function index(Request $request) {
        $filters = $request->only('search');
        return NotificationResource::collection($this->service->getAll($filters, 10));
    }

    public function store(NotificationRequest $request) {
        $data = $this->service->create($request->validated());
        return new NotificationResource($data);
    }

    public function show($id) {
        return new NotificationResource($this->service->repository->find($id));
    }

    public function update(NotificationRequest $request, $id) {
        $data = $this->service->update($id, $request->validated());
        return new NotificationResource($data);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted completely']);
    }
}