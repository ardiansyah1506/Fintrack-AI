<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class RecurringBillRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['name' => 'required|string', 'category' => 'required|string', 'amount' => 'required|numeric', 'repeat' => 'required|string', 'next_due_date' => 'required|date']; }
}