<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AiInsightRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['title' => 'required', 'period' => 'required', 'content' => 'required', 'generated_at' => 'required', 'type' => 'required']; }
}