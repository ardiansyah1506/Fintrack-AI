<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiPredictionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation(): void
    {
        if (!$this->has('name') && $this->has('title')) {
            $this->merge(['name' => $this->input('title')]);
        }
    }

    public function rules(): array
    {
        return [
            'prediction_type' => 'nullable|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'confidence' => 'nullable',
            'generated_at' => 'nullable',
            'status' => 'nullable|string',
        ];
    }
}