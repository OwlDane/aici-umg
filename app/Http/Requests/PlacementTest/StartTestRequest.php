<?php

namespace App\Http\Requests\PlacementTest;

use App\Enums\EducationLevel;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation untuk memulai placement test
 * 
 * Validasi data pre-assessment sebelum user mulai test:
 * - Data diri (nama, email, usia)
 * - Latar belakang pendidikan
 * - Pengalaman sebelumnya (AI, Robotics, Programming)
 * - Minat/interest
 */
class StartTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Semua user (guest & authenticated) bisa akses placement test
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
            // Data diri
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'age' => ['required', 'integer', 'min:6', 'max:100'],
            
            // Latar belakang pendidikan
            'education_level' => ['required', 'string', 'in:' . implode(',', EducationLevel::values())],
            'current_grade' => ['nullable', 'string', 'max:50'], // e.g., "Kelas 5 SD"
            
            // Pengalaman (boolean untuk setiap kategori)
            'experience' => ['required', 'array'],
            'experience.ai' => ['required', 'boolean'],
            'experience.robotics' => ['required', 'boolean'],
            'experience.programming' => ['required', 'boolean'],
            
            // Minat (array of strings)
            'interests' => ['nullable', 'array'],
            'interests.*' => ['string', 'max:100'],
            
            // Placement test ID
            'placement_test_id' => ['required', 'exists:placement_tests,id'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'age.required' => 'Usia wajib diisi.',
            'age.min' => 'Usia minimal 6 tahun.',
            'education_level.required' => 'Jenjang pendidikan wajib dipilih.',
            'education_level.in' => 'Jenjang pendidikan tidak valid.',
            'experience.required' => 'Data pengalaman wajib diisi.',
            'placement_test_id.required' => 'Test ID tidak valid.',
            'placement_test_id.exists' => 'Test tidak ditemukan.',
        ];
    }

    /**
     * Custom attribute names untuk error messages
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'nama lengkap',
            'email' => 'email',
            'age' => 'usia',
            'education_level' => 'jenjang pendidikan',
            'current_grade' => 'kelas saat ini',
            'experience.ai' => 'pengalaman AI',
            'experience.robotics' => 'pengalaman robotics',
            'experience.programming' => 'pengalaman programming',
        ];
    }
}
