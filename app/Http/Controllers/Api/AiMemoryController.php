<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiMemory;
use App\Http\Requests\StoreAiMemoryRequest;
use App\Http\Requests\UpdateAiMemoryRequest;

class AiMemoryController extends Controller
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
    public function store(StoreAiMemoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AiMemory $aiMemory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAiMemoryRequest $request, AiMemory $aiMemory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiMemory $aiMemory)
    {
        //
    }
}
