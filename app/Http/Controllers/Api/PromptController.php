<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromptRequest;
use App\Http\Resources\PromptResource;
use App\Services\PromptService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    use ApiResponse;

    public function __construct(protected PromptService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getAll($request->only('search'), 10);

        return $this->successResponse(
            PromptResource::collection($data),
            'Berhasil mengambil data prompt',
            200,
            'list_prompts',
            'prompts'
        );
    }

    public function store(PromptRequest $request)
    {
        $data = $this->service->create($request->validated());

        return $this->successResponse(
            new PromptResource($data),
            'Prompt berhasil dibuat',
            201,
            'create_prompt',
            'prompt'
        );
    }

    public function show($id)
    {
        $data = app(\App\Contracts\Repositories\PromptRepositoryInterface::class)->find($id);

        return $this->successResponse(
            new PromptResource($data),
            'Berhasil mengambil detail prompt',
            200,
            'get_prompt',
            'prompt'
        );
    }

    public function update(PromptRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        return $this->successResponse(
            new PromptResource($data),
            'Prompt berhasil diperbarui',
            200,
            'update_prompt',
            'prompt'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->successResponse(null, 'Prompt berhasil dihapus', 200, 'delete_prompt', 'prompt');
    }
}