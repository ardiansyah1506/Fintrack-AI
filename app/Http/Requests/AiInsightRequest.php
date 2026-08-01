<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiInsightRequest extends FormRequest
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
            'name' => 'required|string',
            'period' => 'nullable|string',
            'content' => 'required|string',
            'generated_at' => 'nullable',
            'type' => 'nullable|string',
        ];
    }
}