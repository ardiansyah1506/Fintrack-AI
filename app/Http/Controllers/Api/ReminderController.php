<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderRequest;
use App\Http\Resources\ReminderResource;
use App\Services\ReminderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    use ApiResponse;

    public function __construct(protected ReminderService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $data = $this->service->getAll($filters, 10);

        return $this->successResponse(
            ReminderResource::collection($data),
            'Berhasil mengambil data pengingat',
            200,
            'list_reminders',
            'reminders'
        );
    }

    public function store(ReminderRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new ReminderResource($data),
            'Pengingat berhasil dibuat',
            201,
            'create_reminder',
            'reminder'
        );
    }

    public function show($id)
    {
        $data = $this->service->repository->find($id);

        return $this->successResponse(
            new ReminderResource($data),
            'Berhasil mengambil detail pengingat',
            200,
            'get_reminder',
            'reminder'
        );
    }

    public function update(ReminderRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new ReminderResource($data),
            'Pengingat berhasil diperbarui',
            200,
            'update_reminder',
            'reminder'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(
            null,
            'Pengingat berhasil dihapus',
            200,
            'delete_reminder',
            'reminder'
        );
    }
}