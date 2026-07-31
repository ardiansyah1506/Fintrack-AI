<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AiLogRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['request' => 'required', 'response' => 'required', 'model' => 'required', 'duration' => 'required', 'status' => 'required']; }
}