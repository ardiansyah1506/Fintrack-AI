<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AiAchievementRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['title' => 'required', 'description' => 'required', 'reward' => 'required', 'achieved_at' => 'required']; }
}