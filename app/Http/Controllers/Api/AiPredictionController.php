<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiPrediction;
use App\Http\Requests\StoreAiPredictionRequest;
use App\Http\Requests\UpdateAiPredictionRequest;

class AiPredictionController extends Controller
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
    public function store(StoreAiPredictionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AiPrediction $aiPrediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAiPredictionRequest $request, AiPrediction $aiPrediction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiPrediction $aiPrediction)
    {
        //
    }
}
