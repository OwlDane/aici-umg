<?php

namespace App\Http\Requests\PlacementTest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation untuk menyelesaikan test
 * 
 * Validasi saat user submit seluruh test:
 * - Test attempt ID
 * - Konfirmasi bahwa user ingin submit (prevent accidental submission)
 */
class CompleteTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'test_attempt_id' => ['required', 'exists:test_attempts,id'],
            'confirm' => ['required', 'boolean', 'accepted'], // User harus confirm
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'test_attempt_id.required' => 'Session test tidak valid.',
            'test_attempt_id.exists' => 'Session test tidak ditemukan.',
            'confirm.required' => 'Konfirmasi submit wajib diisi.',
            'confirm.accepted' => 'Anda harus mengkonfirmasi untuk submit test.',
        ];
    }
}
