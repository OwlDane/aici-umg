<?php

namespace App\Http\Requests\PlacementTest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation untuk submit jawaban test
 * 
 * Validasi setiap kali user menjawab satu soal:
 * - Test attempt ID (session test yang sedang berjalan)
 * - Question ID (soal yang dijawab)
 * - User answer (jawaban user)
 * - Time spent (waktu yang dihabiskan untuk soal ini)
 */
class SubmitAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user yang memiliki test attempt ini yang bisa submit
        // Validasi lebih lanjut di controller
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
            'test_question_id' => ['required', 'exists:test_questions,id'],
            'user_answer' => ['required', 'string', 'max:255'],
            'time_spent_seconds' => ['required', 'integer', 'min:0', 'max:3600'], // Max 1 jam per soal
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
            'test_question_id.required' => 'Soal tidak valid.',
            'test_question_id.exists' => 'Soal tidak ditemukan.',
            'user_answer.required' => 'Jawaban wajib diisi.',
            'time_spent_seconds.required' => 'Waktu tidak valid.',
            'time_spent_seconds.max' => 'Waktu terlalu lama.',
        ];
    }
}
