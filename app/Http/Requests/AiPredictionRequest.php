<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AiPredictionRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['prediction_type' => 'required', 'title' => 'required', 'description' => 'required', 'confidence' => 'required', 'generated_at' => 'required', 'status' => 'required']; }
}