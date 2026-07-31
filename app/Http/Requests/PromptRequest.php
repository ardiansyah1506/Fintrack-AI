<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PromptRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['name' => 'required', 'prompt' => 'required', 'active' => 'required', 'version' => 'required']; }
}