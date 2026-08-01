<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
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
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'priority' => 'nullable|string',
            'description' => 'nullable|string',
            'repeat' => 'nullable|string',
            'status' => 'nullable|string',
            'telegram_notification' => 'nullable|boolean',
        ];
    }
}