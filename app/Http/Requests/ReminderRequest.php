<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ReminderRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['title' => 'required|string', 'due_date' => 'required|date', 'due_time' => 'required|date_format:H:i', 'priority' => 'nullable|string']; }
}