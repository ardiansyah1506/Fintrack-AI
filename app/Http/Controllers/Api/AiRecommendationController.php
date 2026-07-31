<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiRecommendation;
use App\Http\Requests\StoreAiRecommendationRequest;
use App\Http\Requests\UpdateAiRecommendationRequest;

class AiRecommendationController extends Controller
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
    public function store(StoreAiRecommendationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AiRecommendation $aiRecommendation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAiRecommendationRequest $request, AiRecommendation $aiRecommendation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiRecommendation $aiRecommendation)
    {
        //
    }
}
