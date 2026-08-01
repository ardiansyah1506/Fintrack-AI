<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingGoalRequest extends FormRequest
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
            'target_amount' => 'required|numeric',
            'current_amount' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'icon' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}