<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SavingGoalRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['title' => 'required|string', 'target_amount' => 'required|numeric', 'current_amount' => 'nullable|numeric', 'deadline' => 'nullable|date']; }
}