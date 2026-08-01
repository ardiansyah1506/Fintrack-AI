<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiWarningRequest extends FormRequest
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
            'description' => 'required|string',
            'severity' => 'nullable|string',
            'resolved' => 'nullable|boolean',
        ];
    }
}