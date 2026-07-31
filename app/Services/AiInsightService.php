<?php

namespace App\Services;

use App\Models\AiInsight;
use Illuminate\Database\Eloquent\Collection;

class AiInsightService
{
    public function getAllInsights(): Collection
    {
        return AiInsight::orderBy('generated_at', 'desc')->get();
    }

    public function createInsight(array $data): AiInsight
    {
        return AiInsight::create($data);
    }

    public function deleteInsight($id): void
    {
        $insight = AiInsight::findOrFail($id);
        $insight->delete();
    }
}
