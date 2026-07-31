<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiLog;
use App\Http\Requests\StoreAiLogRequest;
use App\Http\Requests\UpdateAiLogRequest;

class AiLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAiLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AiLog $aiLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAiLogRequest $request, AiLog $aiLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiLog $aiLog)
    {
        //
    }
}
