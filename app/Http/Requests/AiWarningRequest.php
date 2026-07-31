<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AiWarningRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['title' => 'required', 'description' => 'required', 'severity' => 'required', 'resolved' => 'required']; }
}