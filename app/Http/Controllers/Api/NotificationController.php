<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function __construct(protected NotificationService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $data = $this->service->getAll($filters, 10);

        return $this->successResponse(
            NotificationResource::collection($data),
            'Berhasil mengambil data notifikasi',
            200,
            'list_notifications',
            'notifications'
        );
    }

    public function store(NotificationRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new NotificationResource($data),
            'Notifikasi berhasil dibuat',
            201,
            'create_notification',
            'notification'
        );
    }

    public function show($id)
    {
        $data = $this->service->repository->find($id);

        return $this->successResponse(
            new NotificationResource($data),
            'Berhasil mengambil detail notifikasi',
            200,
            'get_notification',
            'notification'
        );
    }

    public function update(NotificationRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new NotificationResource($data),
            'Notifikasi berhasil diperbarui',
            200,
            'update_notification',
            'notification'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'Notifikasi berhasil dihapus', 200, 'delete_notification', 'notification');
    }
}