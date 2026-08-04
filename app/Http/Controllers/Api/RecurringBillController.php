<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecurringBillRequest;
use App\Http\Resources\RecurringBillResource;
use App\Services\RecurringBillService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RecurringBillController extends Controller
{
    use ApiResponse;

    public function __construct(protected RecurringBillService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $data = $this->service->getAll($filters, 10);

        return $this->successResponse(
            RecurringBillResource::collection($data),
            'Berhasil mengambil data tagihan',
            200,
            'list_bills',
            'bills'
        );
    }

    public function store(RecurringBillRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new RecurringBillResource($data),
            'Tagihan berhasil dibuat',
            201,
            'create_bill',
            'bill'
        );
    }

    public function show($id)
    {
        $data = $this->service->repository->find($id);

        return $this->successResponse(
            new RecurringBillResource($data),
            'Berhasil mengambil detail tagihan',
            200,
            'get_bill',
            'bill'
        );
    }

    public function update(RecurringBillRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new RecurringBillResource($data),
            'Tagihan berhasil diperbarui',
            200,
            'update_bill',
            'bill'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(
            null,
            'Tagihan berhasil dihapus',
            200,
            'delete_bill',
            'bill'
        );
    }
}